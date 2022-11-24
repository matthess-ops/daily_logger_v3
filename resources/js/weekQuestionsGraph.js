import moment from "moment";
import Chart from "chart.js/auto";

const colorScheme = [
    "#25CCF7",
    "#FD7272",
    "#54a0ff",
    "#00d2d3",
    "#1abc9c",
    "#2ecc71",
    "#3498db",
    "#9b59b6",
    "#34495e",
    "#16a085",
    "#27ae60",
    "#2980b9",
    "#8e44ad",
    "#2c3e50",
    "#f1c40f",
    "#e67e22",
    "#e74c3c",
    "#ecf0f1",
    "#95a5a6",
    "#f39c12",
    "#d35400",
    "#c0392b",
    "#bdc3c7",
    "#7f8c8d",
    "#55efc4",
    "#81ecec",
    "#74b9ff",
    "#a29bfe",
    "#dfe6e9",
    "#00b894",
    "#00cec9",
    "#0984e3",
    "#6c5ce7",
    "#ffeaa7",
    "#fab1a0",
    "#ff7675",
    "#fd79a8",
    "#fdcb6e",
    "#e17055",
    "#d63031",
    "#feca57",
    "#5f27cd",
    "#54a0ff",
    "#01a3a4",
];


//filter the daily question for startDate and endDate
const filterDailyQuestionsForDate = (startDate, endDate) => {
    const filtered = dailyQuestions.filter((log) => {
        if (
            moment(log.date_today) >= startDate &&
            moment(log.date_today) <= endDate
        ) {
            return log;
        }
    });

    return filtered;
};

// get the unique questions from for the daily questions logs
const getUniqueQuestions = (dailyQuestions) => {
    let allQuestions = [];

    dailyQuestions.forEach((dailyQuestion) => {
        allQuestions = allQuestions.concat(dailyQuestion.questions);
    });

    const uniqueQuestions = [...new Set(allQuestions)];
    return uniqueQuestions;
};
//make the the dateRange. Each graph in dateRange consist out of 8 weeks.
//startDate starts on a monday
//endDate
const makeDateRange = (startDate, endDate) => {
    let chunkArray = [];
    let graphArray = [];
    let weekStartDate = startDate.clone();
    while (weekStartDate < endDate) {
        let newWeek = {
            //needs to be cloned else you you override the original object
            weekStartDate: weekStartDate.clone(),
            weekEndDate: weekStartDate.clone().add(6, "days").clone(),
            weekNr: weekStartDate.clone().format("WW"),
        };

        graphArray.push(newWeek);
        if (graphArray.length >= 8) {
            chunkArray.push(graphArray);
            graphArray = [];
        }
        weekStartDate.add(7, "days");
    }

    if (graphArray.length > 0) {
        chunkArray.push(graphArray);
    }
    return chunkArray;
};


// add for each week for the each 8 week graph in graphDateRange, the daily questions
// logs belonging to that week
const addLogsToDataRange = (graphDateRange, filteredLogs) => {
    graphDateRange.forEach((dataRange) => {
        dataRange.forEach((week) => {
            const questionsLogs = filteredLogs.filter((log) => {
                if (
                    moment(log.date_today) >= week.weekStartDate &&
                    moment(log.date_today) <= week.weekEndDate
                ) {
                    return log;
                }
            });
            week.questionsLogs = questionsLogs;
        });
    });

    return graphDateRange;
};

//get for each unique question foreach 8 week graph in graphDateRange. The average
// scores (for full 8 week graph, 8 average scores) of the unique question for the 8 week graph.
const calculateGraphDataRangeQuestionAverages = (
    graphDateRange,
    uniqueQuestions
) => {
    let formattedData = [];
    graphDateRange.forEach((graph, index) => {
        let graphQuestionResults = [];
        uniqueQuestions.forEach((uniqueQuestion) => {
            let graphQuestionWeekTotals = [];
            graph.forEach((week) => {
                let weekQuestionTotal = 0;
                let weekQuestionCount = 0;
                week.questionsLogs.forEach((log) => {
                    if (log != null) {

                        //since the names of the daily question and the scores of the daily questions
                    // are in seperate arrays. the sequence of the daily question in the names array might differ
                    //between dailyQuestionLogs. Therefor the index of the uniqueQuestion in the names array
                    //first need to be determined. With this index the correct score of the dailyQuestion name can
                    // be index from the score array
                        const index = log.questions.findIndex((question) => {
                            return question === uniqueQuestion;
                        });
                        if (index != -1) {
                            weekQuestionTotal =
                                weekQuestionTotal + log.scores[index];
                            weekQuestionCount = weekQuestionCount + 1;
                        }
                    }
                });

                if (weekQuestionCount > 0) {
                    const averageWeekScore =
                        weekQuestionTotal / weekQuestionCount;
                    graphQuestionWeekTotals.push(averageWeekScore);
                } else { //needed because else an division by zero error can occur
                    const averageWeekScore = 0;
                    graphQuestionWeekTotals.push(averageWeekScore);
                }
            });
            graphQuestionResults.push({
                question: uniqueQuestion,
                questionGraphScores: graphQuestionWeekTotals,
            });
        });

        const formatData = {
            graphQuestionAverages: graphQuestionResults,
            weekData: graph,
        };
        formattedData.push(formatData);
    });
    return formattedData;
};

//convert all 8 week graph question averages to chartjs compatable datasets
const makeGraphDatasets = (dateRange) => {
    dateRange.forEach((graph) => {
        let colorIndex = 0;
        let datasets = [];
        graph.graphQuestionAverages.forEach((graphQuestion) => {

            colorIndex += 1;
            const dataset = {
                label: graphQuestion.question,
                backgroundColor: colorScheme[colorIndex],
                data: graphQuestion.questionGraphScores,
            };
            datasets.push(dataset);
        });
        graph.datasets = datasets;
        graph.filteredDatasets = datasets;
    });

    return dateRange;
};

// create for each column in the 8 week graphs the corresponding chartjs label
const makeLabels = (graphDataRange) => {
    graphDataRange.forEach((graph) => {
        let labels = [];

        graph.weekData.forEach((week) => {
            const date =
                week.weekStartDate.format("YYYY-WW")

            labels.push(date);
        });
        graph.labels = labels;
    });

    return graphDataRange;
};

//make the question checkboxes
const makeGroupCheckBoxes =(divId,checkBoxNames,title)=>{
    const groupDiv =document.createElement("div")
    groupDiv.id = divId
    const checkBoxDiv =document.getElementById("checkBoxes")
    checkBoxDiv.appendChild(groupDiv)
    const divOfInterest = document.getElementById(divId)
    checkBoxDiv.appendChild(divOfInterest)

    const newTitle = document.createElement("h4");
    newTitle.innerText = title
    divOfInterest.appendChild(newTitle);


    checkBoxNames.forEach((checkBoxName,index) => {
        const newLabel = document.createElement("label");
        newLabel.setAttribute("for", checkBoxName);
        newLabel.innerHTML = checkBoxName;

        const newCheckbox = document.createElement("input");
        newCheckbox.setAttribute("type", "checkbox");
        newCheckbox.setAttribute("id", checkBoxName);
        newCheckbox.setAttribute("checked", true);
        newCheckbox.setAttribute('value',checkBoxName)
        const br = document.createElement("br");

        divOfInterest.appendChild(newLabel);
        divOfInterest.appendChild(newCheckbox);
        divOfInterest.appendChild(br);
    });
}

//makes the chart
const makeChart = (chartLabels, chartDatasets, chartName, weeknr) => {
    let chartStatus = Chart.getChart(chartName); // <canvas> id
    if (chartStatus != undefined) {
        chartStatus.destroy();
    }

    let newCanvas = document.createElement("canvas");
    newCanvas.id = chartName;
    document.getElementById("chartDiv").appendChild(newCanvas);

    var ctx = document.getElementById(chartName).getContext("2d");

    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: chartLabels,
            datasets: chartDatasets,
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Week resultaten :" + weeknr,
                },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: false,
                },
                y: {
                    stacked: false,
                },

            },
        },
    });

    myChart.update();
};

//create for each 8 week graph in dateRange a seperate chart
const makeQuestionCharts = (dateRange) => {
    dateRange.forEach((graph,index) => {
        makeChart(
            graph.labels,
            graph.filteredDatasets,
            "chart_" + index,
            index
        );
    });
};


//foreach graph keep the question data of interest
const filterDataRangeForCheckBoxes =(graphs,questions)=>{

    const labelsToRemove = questions
    graphs.forEach((graph) => {
        const filteredGraphDatasets = []
        graph.datasets.forEach(label => {
            let keepData = false
            labelsToRemove.forEach(labelToRemove => {
                    if(label.label == labelToRemove){
                        keepData = true
                    }
            });
            if(keepData == true){
                filteredGraphDatasets.push(label)
            }
        });
        graph.filteredDatasets = filteredGraphDatasets
    });
    makeQuestionCharts(graphs);


}

//main function
const generateWeeklyQuestionsGraphs = (startDate, endDate) => {
    console.log("generateWeeklyQuestionsGraphs called");
    const startDateStr = startDate;
    const endDateStr = endDate;

    const startDateMoment = moment(startDateStr, "YYYY-[W]WW").weekday(1);
    const endDateMoment = moment(endDateStr, "YYYY-[W]WW").weekday(8);

    const filteredDailyQuestionsForDate = filterDailyQuestionsForDate(
        startDateMoment,
        endDateMoment
    );
    // console.log("filteredDailyQuestionsForDate");
    // console.log(filteredDailyQuestionsForDate);

    const uniqueQuestions = getUniqueQuestions(filteredDailyQuestionsForDate);
    // console.log("uniqueQuestions");
    // console.log(uniqueQuestions);

    const graphDataRange = makeDateRange(startDateMoment, endDateMoment);
    // console.log("graphdatrange");
    // console.log(graphDataRange);
    const graphDataRangeLogs = addLogsToDataRange(
        graphDataRange,
        filteredDailyQuestionsForDate
    );
    // console.log("graphDataRangeLogs");
    // console.log(graphDataRangeLogs);

    const calculatedGraphDataRangeQuestionsAverage =
        calculateGraphDataRangeQuestionAverages(
            graphDataRangeLogs,
            uniqueQuestions
        );
    // console.log("calculatedGraphDataRangeQuestionsAverage");
    // console.log(calculatedGraphDataRangeQuestionsAverage);

    const graphDatasets = makeGraphDatasets(
        calculatedGraphDataRangeQuestionsAverage,
        uniqueQuestions
    );
    // console.log("graphDatasets");
    // console.log(graphDatasets);

    const graphLabels = makeLabels(graphDatasets)
    // console.log("graphLabels")
    // console.log(graphLabels)

    const checkBoxes = document.getElementById("checkBoxes")
        if(checkBoxes.innerHTML !=""){
            checkBoxes.innerHTML = ""

        }

    makeGroupCheckBoxes('questionCheckBoxes',uniqueQuestions,"Filter vragen:")
    makeQuestionCharts(graphLabels)
    document.getElementById('checkBoxes').addEventListener('change',()=>{

        const checkedBoxes = uniqueQuestions.filter(checkBoxId =>
            document.getElementById(checkBoxId).checked ==true
            )

            filterDataRangeForCheckBoxes(graphLabels,checkedBoxes)

    })
};

export default generateWeeklyQuestionsGraphs;
