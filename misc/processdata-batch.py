import logging
import sagemaker
from sagemaker.spark.processing import PySparkProcessor
from datetime import date

def main():
    sagemaker_logger = logging.getLogger("sagemaker")
    sagemaker_logger.setLevel(logging.INFO)
    sagemaker_logger.addHandler(logging.StreamHandler())

    sagemaker_session = sagemaker.Session()
    role = sagemaker.get_execution_role()
    
    input_bucket = 's3bucket.testcase1'
    input_key = ''
    input_file = ''
    output_bucket = 's3bucket-mxnet-out'
    output_key = os.path.join("processed", "batch-" + str(date.today()))
    
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
