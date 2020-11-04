import os
os.environ["HADOOP_HOME"] = "C:\winutils"

from pyspark.ml import Pipeline
from pyspark.ml.feature import Word2Vec, RegexTokenizer, StopWordsRemover
from pyspark.sql import SparkSession, SQLContext, Row
from pyspark.ml.clustering import KMeans
from pyspark.ml.evaluation import ClusteringEvaluator
from pyspark.ml.tuning import CrossValidator, ParamGridBuilder
from pyspark.ml.evaluation import ClusteringEvaluator
import pyspark.sql.functions as F


spark = SparkSession.builder.appName('example').getOrCreate()
sc = spark.sparkContext
sqlContext = SQLContext(sc)


# think about creating a list of stopwords for stopwordsremover e.g [article, author, research, paper]
# think about removing Abstracts with length less than some n where n > 1

data = spark.read.json("extract_abstracts_from_json-2020-10-30_91040.json", multiLine=True)
data = data.where(data.Abstract.isNotNull())
data = data.dropDuplicates()
data = data.withColumn("AbstractLength", F.length(data.Abstract))
data = data.filter(data.AbstractLength > 2)

data.show()

train, test = data.randomSplit([0.9, 0.1], seed=12345)
# train, test = data.randomSplit([0.5, 0.5], seed=12345)

regexTokenizer = RegexTokenizer(inputCol="Abstract", outputCol="tokens", pattern="\\W")
remover = StopWordsRemover(inputCol=regexTokenizer.getOutputCol(), outputCol="stripped")
word2Vec = Word2Vec(vectorSize= 300, minCount=3, inputCol=remover.getOutputCol(), outputCol="features")
kmeans = KMeans()

pipeline = Pipeline(stages=[regexTokenizer, remover, word2Vec, kmeans])

paramGrid = ParamGridBuilder().addGrid(kmeans.k, [x for x in range(2, 11)]).build()

evaluator = ClusteringEvaluator(predictionCol="prediction")
crossval = CrossValidator(estimator=pipeline,
                          estimatorParamMaps=paramGrid,
                          evaluator=evaluator,
                          numFolds=3)  # use 3+ folds in practice


cvModel = crossval.fit(train)

best_model = cvModel.bestModel
k = best_model.stages[3].summary.k
print("best k: ", k)
# print(training_summary)
# print(training_summary.totalIterations)
# print(training_summary.objectiveHistor)

prediction = cvModel.transform(test)
print(evaluator.evaluate(prediction))
for i in range(k):
    prediction.filter(prediction.groupID == i).show()
