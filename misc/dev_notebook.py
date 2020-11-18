{
 "metadata": {
  "language_info": {
   "codemirror_mode": {
    "name": "ipython",
    "version": 3
   },
   "file_extension": ".py",
   "mimetype": "text/x-python",
   "name": "python",
   "nbconvert_exporter": "python",
   "pygments_lexer": "ipython3",
   "version": "3.7.4-final"
  },
  "orig_nbformat": 2,
  "kernelspec": {
   "name": "python3",
   "display_name": "Python 3"
  }
 },
 "nbformat": 4,
 "nbformat_minor": 2,
 "cells": [
  {
   "cell_type": "code",
   "execution_count": 1,
   "metadata": {},
   "outputs": [],
   "source": [
    "import os\n",
    "os.environ[\"HADOOP_HOME\"] = \"C:\\winutils\"\n",
    "\n",
    "import stop_words\n",
    "\n",
    "from pyspark.ml import Pipeline\n",
    "from pyspark.ml.feature import Word2Vec, RegexTokenizer, StopWordsRemover, Normalizer\n",
    "from pyspark.sql import SparkSession, SQLContext, Row\n",
    "from pyspark.ml.clustering import KMeans\n",
    "from pyspark.ml.evaluation import ClusteringEvaluator\n",
    "from pyspark.ml.tuning import CrossValidator, ParamGridBuilder\n",
    "from pyspark.ml.evaluation import ClusteringEvaluator\n",
    "import pyspark.sql.functions as F\n"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 2,
   "metadata": {},
   "outputs": [],
   "source": [
    "spark = SparkSession.builder.appName('example').getOrCreate()\n",
    "sc = spark.sparkContext\n",
    "sqlContext = SQLContext(sc)"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 3,
   "metadata": {},
   "outputs": [],
   "source": [
    "data = spark.read.json(\"extract_abstracts_from_json-2020-10-30_91040.json\", multiLine=True)"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 4,
   "metadata": {},
   "outputs": [],
   "source": [
    "data = data.where(data.Abstract.isNotNull())\n",
    "data = data.dropDuplicates()\n",
    "data = data.withColumn(\"AbstractLength\", F.length(data.Abstract))\n",
    "data = data.filter(data.AbstractLength > 49)"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": null,
   "metadata": {},
   "outputs": [],
   "source": [
    "print(\"Number of rows: \", data.count())\n",
    "data.show()\n",
    "data.describe().show()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 5,
   "metadata": {},
   "outputs": [],
   "source": [
    "train, test = data.randomSplit([0.9, 0.1], seed=12345)"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 6,
   "metadata": {},
   "outputs": [],
   "source": [
    "regexTokenizer = RegexTokenizer(inputCol=\"Abstract\", outputCol=\"tokens\", pattern=\"[A-Za-z]+\", gaps=False, minTokenLength=1)\n",
    "remover = StopWordsRemover(inputCol=regexTokenizer.getOutputCol(), outputCol=\"stripped\", stopWords=stop_words.WORDS)\n",
    "word2Vec = Word2Vec(vectorSize= 300, minCount=2, inputCol=remover.getOutputCol(), outputCol=\"features\")\n",
    "# normalizer = Normalizer(inputCol=\"WordVectors\", outputCol=\"features\", p=2)\n",
    "kmeans = KMeans()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 7,
   "metadata": {},
   "outputs": [],
   "source": [
    "pipeline = Pipeline(stages=[regexTokenizer, remover, word2Vec, kmeans])"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 8,
   "metadata": {},
   "outputs": [],
   "source": [
    "paramGrid = ParamGridBuilder().addGrid(kmeans.k, [x for x in range(2, 11)]).build()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 9,
   "metadata": {},
   "outputs": [],
   "source": [
    "evaluator = ClusteringEvaluator(predictionCol=\"prediction\")\n",
    "crossval = CrossValidator(estimator=pipeline,\n",
    "                          estimatorParamMaps=paramGrid,\n",
    "                          evaluator=evaluator,\n",
    "                          numFolds=3)  # use 3+ folds in practice"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 10,
   "metadata": {},
   "outputs": [],
   "source": [
    "cvModel = crossval.fit(train)"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 11,
   "metadata": {},
   "outputs": [
    {
     "output_type": "stream",
     "name": "stdout",
     "text": [
      "best k:  2\n"
     ]
    }
   ],
   "source": [
    "best_model = cvModel.bestModel\n",
    "k = best_model.stages[3].summary.k\n",
    "print(\"best k: \", k)"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 12,
   "metadata": {},
   "outputs": [],
   "source": [
    "prediction = cvModel.transform(test)"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 13,
   "metadata": {},
   "outputs": [
    {
     "output_type": "stream",
     "name": "stdout",
     "text": [
      "0.6834833734582161\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "|            Abstract|item_no|AbstractLength|              tokens|            stripped|            features|prediction|\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "|Human beings poss...|    542|          1362|[human, beings, p...|[human, beings, p...|[0.00228801508805...|         1|\n",
      "|The article focus...|    196|           346|[the, article, fo...|[focuses, delusio...|[1.04881864293323...|         0|\n",
      "|The paper draws o...|    298|          1414|[the, paper, draw...|[paper, draws, ph...|[0.00129629143162...|         0|\n",
      "|Abstract Mathemat...|    395|          1567|[abstract, mathem...|[abstract, mathem...|[0.00108476805350...|         1|\n",
      "|Mainstream resear...|    212|           736|[mainstream, rese...|[mainstream, rese...|[0.00166257270917...|         0|\n",
      "|This article exam...|    569|          1274|[this, article, e...|[examines, contro...|[0.00195918453364...|         0|\n",
      "|During the last t...|    113|          1414|[during, the, las...|[decades, united,...|[0.00212687933608...|         1|\n",
      "|The article offer...|    242|           382|[the, article, of...|[offers, informat...|[3.13774200163386...|         0|\n",
      "|The article offer...|    451|           356|[the, article, of...|[offers, positive...|[0.00102096950718...|         1|\n",
      "|In this article, ...|    336|          1425|[in, this, articl...|[evaluation, engl...|[0.00117253795813...|         0|\n",
      "|Information about...|    351|          1526|[information, abo...|[information, gen...|[0.00180934706720...|         1|\n",
      "|South Africa is a...|    562|           876|[south, africa, i...|[south, africa, s...|[0.00122530885700...|         0|\n",
      "|*TECHNOLOGY *GEOG...|    457|            76|[technology, geog...|[technology, geog...|[0.00205839752951...|         1|\n",
      "|Federal Rule of E...|    568|          1224|[federal, rule, o...|[federal, rule, e...|[9.91792706400636...|         0|\n",
      "|It is time to do ...|    274|            64|[it, is, time, to...|[time, away, flas...|[7.10301702686895...|         0|\n",
      "|We study the sens...|    228|          1618|[we, study, the, ...|[study, sensitivi...|[0.00131705560744...|         0|\n",
      "|The annual rainfa...|    429|          1160|[the, annual, rai...|[annual, rainfall...|[0.00142555352396...|         0|\n",
      "|The article discu...|    435|           376|[the, article, di...|[discusses, decol...|[0.00169129472903...|         1|\n",
      "|As English is adv...|    350|           379|[as, english, is,...|[english, advanci...|[3.07801185408607...|         0|\n",
      "|This article focu...|     71|          1223|[this, article, f...|[focuses, relatio...|[0.00125127507453...|         0|\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "only showing top 20 rows\n",
      "\n"
     ]
    }
   ],
   "source": [
    "print(evaluator.evaluate(prediction))\n",
    "prediction.show()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": null,
   "metadata": {},
   "outputs": [],
   "source": [
    "prediction.describe().show()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": null,
   "metadata": {},
   "outputs": [],
   "source": [
    "prediction.filter(prediction.prediction == 1).show()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": 14,
   "metadata": {},
   "outputs": [
    {
     "output_type": "stream",
     "name": "stdout",
     "text": [
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "|            Abstract|item_no|AbstractLength|              tokens|            stripped|            features|prediction|\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "|The article focus...|    196|           346|[the, article, fo...|[focuses, delusio...|[1.04881864293323...|         0|\n",
      "|The paper draws o...|    298|          1414|[the, paper, draw...|[paper, draws, ph...|[0.00129629143162...|         0|\n",
      "|Mainstream resear...|    212|           736|[mainstream, rese...|[mainstream, rese...|[0.00166257270917...|         0|\n",
      "|This article exam...|    569|          1274|[this, article, e...|[examines, contro...|[0.00195918453364...|         0|\n",
      "|The article offer...|    242|           382|[the, article, of...|[offers, informat...|[3.13774200163386...|         0|\n",
      "|In this article, ...|    336|          1425|[in, this, articl...|[evaluation, engl...|[0.00117253795813...|         0|\n",
      "|South Africa is a...|    562|           876|[south, africa, i...|[south, africa, s...|[0.00122530885700...|         0|\n",
      "|Federal Rule of E...|    568|          1224|[federal, rule, o...|[federal, rule, e...|[9.91792706400636...|         0|\n",
      "|It is time to do ...|    274|            64|[it, is, time, to...|[time, away, flas...|[7.10301702686895...|         0|\n",
      "|We study the sens...|    228|          1618|[we, study, the, ...|[study, sensitivi...|[0.00131705560744...|         0|\n",
      "|The annual rainfa...|    429|          1160|[the, annual, rai...|[annual, rainfall...|[0.00142555352396...|         0|\n",
      "|As English is adv...|    350|           379|[as, english, is,...|[english, advanci...|[3.07801185408607...|         0|\n",
      "|This article focu...|     71|          1223|[this, article, f...|[focuses, relatio...|[0.00125127507453...|         0|\n",
      "|A scheme to reali...|    418|           758|[a, scheme, to, r...|[scheme, realize,...|[9.85367329121800...|         0|\n",
      "|Background: Tradi...|    132|          2893|[background, trad...|[background, trad...|[0.00133333197019...|         0|\n",
      "|The feature ranki...|    230|          1145|[the, feature, ra...|[feature, ranking...|[0.00105892068984...|         0|\n",
      "|Data analysis Med...|    231|            75|[data, analysis, ...|[data, analysis, ...|[9.98128103674389...|         0|\n",
      "|The article discu...|    373|           483|[the, article, di...|[discusses, think...|[3.33423399402258...|         0|\n",
      "|Individual partic...|    258|           111|[individual, part...|[individual, part...|[0.00189130794994...|         0|\n",
      "|Informed by Posts...|    335|           970|[informed, by, po...|[informed, postst...|[8.38595888517720...|         0|\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "only showing top 20 rows\n",
      "\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "|            Abstract|item_no|AbstractLength|              tokens|            stripped|            features|prediction|\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "|Human beings poss...|    542|          1362|[human, beings, p...|[human, beings, p...|[0.00228801508805...|         1|\n",
      "|Abstract Mathemat...|    395|          1567|[abstract, mathem...|[abstract, mathem...|[0.00108476805350...|         1|\n",
      "|During the last t...|    113|          1414|[during, the, las...|[decades, united,...|[0.00212687933608...|         1|\n",
      "|The article offer...|    451|           356|[the, article, of...|[offers, positive...|[0.00102096950718...|         1|\n",
      "|Information about...|    351|          1526|[information, abo...|[information, gen...|[0.00180934706720...|         1|\n",
      "|*TECHNOLOGY *GEOG...|    457|            76|[technology, geog...|[technology, geog...|[0.00205839752951...|         1|\n",
      "|The article discu...|    435|           376|[the, article, di...|[discusses, decol...|[0.00169129472903...|         1|\n",
      "|The article prese...|    524|           466|[the, article, pr...|[presents, epm, w...|[2.79647484168653...|         1|\n",
      "|While entrepreneu...|    407|          1181|[while, entrepren...|[entrepreneurship...|[0.00165809734048...|         1|\n",
      "|Interactions with...|    374|           535|[interactions, wi...|[interactions, hu...|[0.00150675124385...|         1|\n",
      "|Previous studies ...|     21|          1617|[previous, studie...|[previous, studie...|[0.00227015398010...|         1|\n",
      "|This paper discus...|    139|          1107|[this, paper, dis...|[paper, discusses...|[0.00186368466445...|         1|\n",
      "|*ENGINEERING *TEC...|    431|            67|[engineering, tec...|[engineering, tec...|[0.00145056967933...|         1|\n",
      "|Expenditure on re...|    156|          1888|[expenditure, on,...|[expenditure, res...|[0.00193737639372...|         1|\n",
      "|621110 Offices of...|     95|           136|[offices, of, phy...|[offices, physici...|[0.00122780161909...|         1|\n",
      "|The metaphors tha...|    378|           627|[the, metaphors, ...|[metaphors, stude...|[0.00143873042484...|         1|\n",
      "+--------------------+-------+--------------+--------------------+--------------------+--------------------+----------+\n",
      "\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "|Abstract|item_no|AbstractLength|tokens|stripped|features|prediction|\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "|Abstract|item_no|AbstractLength|tokens|stripped|features|prediction|\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "|Abstract|item_no|AbstractLength|tokens|stripped|features|prediction|\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "+--------+-------+--------------+------+--------+--------+----------+\n",
      "\n"
     ]
    }
   ],
   "source": [
    "prediction.filter(prediction.prediction == 0).show()\n",
    "prediction.filter(prediction.prediction == 1).show()\n",
    "prediction.filter(prediction.prediction == 2).show()\n",
    "prediction.filter(prediction.prediction == 3).show()\n",
    "prediction.filter(prediction.prediction == 4).show()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": null,
   "metadata": {},
   "outputs": [],
   "source": [
    "rt = RegexTokenizer(inputCol=\"Abstract\", outputCol=\"tokens\", pattern=\"[A-Za-z]+\", gaps=False)\n",
    "r = rt.transform(test)\n",
    "r.show()"
   ]
  },
  {
   "cell_type": "code",
   "execution_count": null,
   "metadata": {},
   "outputs": [],
   "source": []
  }
 ]
}