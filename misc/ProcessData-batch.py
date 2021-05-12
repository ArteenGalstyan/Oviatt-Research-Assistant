import logging
import os
import sagemaker
from sagemaker.spark.processing import PySparkProcessor
from datetime import date
import boto3

def main():
    session = boto3.session.Session()
    
    sagemaker_logger = logging.getLogger("sagemaker")
    sagemaker_logger.setLevel(logging.INFO)
    sagemaker_logger.addHandler(logging.StreamHandler())

    sagemaker_session = sagemaker.Session(session)
    role = sagemaker.get_execution_role()
    
    input_bucket = 's3bucket-in'
    input_key = 'citations'
    input_file = 'citations-output.csv'
    output_bucket = 's3bucket-mxnet-out'
    output_key = os.path.join("processed", "batch-" + str(date.today()))
    
#     parser = argparse.ArgumentParser(description="app inputs and outputs")
#     parser.add_argument("--s3_input_bucket", type=str, help="s3 input bucket")
#     parser.add_argument("--s3_input_key", type=str, help="s3 input key")
#     parser.add_argument("--s3_input_file", type=str, help="s3 input file")
#     parser.add_argument("--s3_output_bucket", type=str, help="s3 output bucket")
#     parser.add_argument("--s3_output_key", type=str, help="s3 output key")
#     args = parser.parse_args()
    
    # Run the processing job
    spark_processor = PySparkProcessor(
        base_job_name="sm-spark",
        framework_version="2.4",
        role=role,
        instance_count=2,
        instance_type="ml.m5.xlarge",
        max_runtime_in_seconds=15000,
    )

    spark_processor.run(
        submit_app="preprocess-batch.py",
        arguments=["--s3_input_bucket", input_bucket,
                   "--s3_input_key", input_key,
                   "--s3_input_file", input_file,
                   "--s3_output_bucket", output_bucket,
                   "--s3_output_key", output_key],
        logs=False
    )
    
    return

if __name__ is '__main__':
    main()