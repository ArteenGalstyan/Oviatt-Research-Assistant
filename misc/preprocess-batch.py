%%writefile preprocess-batch.py
from __future__ import print_function
from __future__ import unicode_literals

import argparse
import csv
import os
import shutil
import sys
import time
import boto3


import pyspark
from pyspark.sql import SparkSession
from pyspark.ml import Pipeline
from pyspark.ml.feature import (
    Word2Vec,
    RegexTokenizer,
    StopWordsRemover,
    MinMaxScaler
)
from pyspark.sql.functions import *
from pyspark.sql.types import (
    IntegerType,
    StringType,
    StructField,
    StructType,
)


# def csv_line(data):
#     return str(data[0]) + ',' + str(data[1]) + ',' + ','.join(str(d) for d in data[2])

def csv_line(data):
    return str(data[0]) + ',' + ','.join(str(d) for d in data[1])

def main():
    parser = argparse.ArgumentParser(description="app inputs and outputs")
    parser.add_argument("--s3_input_bucket", type=str, help="s3 input bucket")
    parser.add_argument("--s3_input_key", type=str, help="s3 input key")
    parser.add_argument("--s3_input_file", type=str, help="s3 input file")
    parser.add_argument("--s3_output_bucket", type=str, help="s3 output bucket")
    parser.add_argument("--s3_output_key", type=str, help="s3 output key")
    args = parser.parse_args()

    
    spark = SparkSession.builder.appName("PySparkApp").getOrCreate()

    # This is needed to save RDDs which is the only way to write nested Dataframes into CSV format
    spark.sparkContext._jsc.hadoopConfiguration().set("mapred.output.committer.class",
                                                      "org.apache.hadoop.mapred.FileOutputCommitter")

    # Defining the schema corresponding to the input data. The input data does contain the headers
    schema = StructType([StructField("item_no", IntegerType(), True), 
                         StructField("Abstract", StringType(), True)])

    # Downloading the data from S3 into a Dataframe
#     total_df = spark.read.csv(('s3://' + os.path.join(args.s3_input_bucket,
#                                                    'citations.csv')), header=True, schema=schema)
    
    total_df = spark.read.csv(('s3://' + os.path.join(args.s3_input_bucket, args.s3_input_key,
                                               args.s3_input_file)), header=True, schema=schema)
    
    total_df = total_df.where(total_df.Abstract.isNotNull())
    total_df = total_df.dropDuplicates()
    
    regexTokenizer = RegexTokenizer(inputCol="Abstract", outputCol="tokens", pattern="\\W")
    remover = StopWordsRemover(inputCol="tokens", outputCol="stripped")
    word2Vec = Word2Vec(vectorSize= 100, minCount=2, inputCol="stripped", outputCol="vectors")
    scaler = MinMaxScaler(inputCol="vectors", outputCol="features")

    
    # The pipeline comprises of the steps added above
    pipeline = Pipeline(stages=[regexTokenizer, remover, word2Vec, scaler])
    
    # This step trains the feature transformers
    model = pipeline.fit(total_df)
    
    # This step transforms the dataset with information obtained from the previous fit
    transformed_total_df = model.transform(total_df)
    
    batch_rdd = transformed_total_df.rdd.map(lambda x: (x.item_no, x.features))
    batch_lines = batch_rdd.map(csv_line)
    batch_lines.saveAsTextFile('s3://' + os.path.join(args.s3_output_bucket, args.s3_output_key))
    


if __name__ == "__main__":
    main()
