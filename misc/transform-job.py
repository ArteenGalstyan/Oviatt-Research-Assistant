import os
import boto3
import io
import sagemaker
import pandas as pd


def main():
    s3_client = boto3.client('s3')
    
    # bucket containing preprocessed-batch input
    bucket = 's3bucket-mxnet-out'
    
    # path to most recent preprocessed-batch batch

    key1 = 'processed/batch-' + str(date.today()) + '/'
    
    # output folder
    key2 = 'infrences'
    
    # enumerated input data
    file_prefix = 'part-'
    
    # partial pathway to input data
    input_data_path = key1 + file_prefix
    
    # where to store infrences
    output_data_path = 's3://{}/{}'.format(bucket, key2)

    # name of kmeans model to be used
    model_name = 'kmeans-2021-03-04-04-16-48-746'
    
    
    # collect and filter for appropriate input data paths
    obj_list=s3_client.list_objects(Bucket=bucket)
    input_data_paths = list(map(lambda i: i['Key'], filter(lambda x: input_data_path in x['Key'], obj_list['Contents'])))
    
    # create a transform job
    transform_job = sagemaker.transformer.Transformer(
        model_name = model_name,
        instance_count = 1,
        instance_type = 'ml.m4.xlarge',
        strategy = 'MultiRecord',
        assemble_with = 'Line',
        output_path = output_data_path,
        base_transform_job_name='inference-pipelines-batch',
        sagemaker_session=sagemaker.Session(),
        accept = 'text/csv')
    
    # preform a transformation on the preprocessed-batch input files
    for path in input_data_paths:
        transform_job.transform(data = 's3://{}/{}'.format(bucket, path), 
                                content_type = 'text/csv', 
                                split_type = 'Line',
                               input_filter="$[1:]",
                                join_source= "Input",
                                output_filter="$")
    
    return

if __name__ == "__main__":
    main()
