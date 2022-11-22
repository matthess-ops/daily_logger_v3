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

const filterDailyQuestionsForDate = (startDate, endDate) => {
    const filtered = dailyQuestions.filter((log) => {
        if (
            moment(log.created_at) >= startDate &&
            moment(log.created_at) <= endDate
        ) {
            return log;
        }
    });

    return filtered;
};

const getUniqueQuestions = (dailyQuestions) => {
    let allQuestions = [];

    dailyQuestions.forEach(dailyQuestion => {
        allQuestions = allQuestions.concat(dailyQuestion.questions)

    });

    const uniqueQuestions = [...new Set(allQuestions)];
    return uniqueQuestions
};

const makeDailyDataRange = (
    uniqueDailyQuestions,
    startDate,
    endDate
) => {

    const startWeekValue = startDate;

    const endWeekValue = endDate;
    console.log("startWeekValue = ", startWeekValue)
    console.log("endWeekValue = ", endWeekValue)

    const intStartWeek = parseInt(startWeekValue.split("W")[1]);
    const intEndWeek = parseInt(endWeekValue.split("W")[1]);
    const startYear = startWeekValue.split("W")[0].substring(0, 4);

    const weekDiff = (intEndWeek - intStartWeek) + 1;

    let dateRange = [];
    for (let i = 0; i < weekDiff; i++) {
        const newWeek = {
            weekNr: intStartWeek + i,
            mondayDate: moment(startYear)
                .add(intStartWeek + i, "weeks")
                .weekday(1),
            sundayDate: moment(startYear)
                .add(intStartWeek + i, "weeks")
                .weekday(7),
            dailyQuestionsLogs: null,
            uniqueDailyQuestions: uniqueDailyQuestions,
            datasets: null,
            labels: null,
            filteredDatasets: null,
        };
        dateRange.push(newWeek);
    }
    return dateRange;
};

const addDailyQuestionsLogToDateRange = (dateRange, filteredDailyQuestionLogs) => {
    dateRange.forEach((week) => {
        let logs = [];
        for (let i = 0; i < 7; i++) {
            const date = week.mondayDate.clone().add(i, "days");
            const thisLog = null;
            filteredDailyQuestionLogs.forEach((log) => {
                if (log.date_today == date.format("YYYY-MM-DD")) {
                    thisLog = log;
                }
            });

            logs.push({
                date: date,
                log: thisLog,
            });
        }
        week.dailyQuestionsLogs = logs;
    });
    return dateRange;
};

const calcDailyQuestionsAverages = (dataRange) => {

    // console.log(dataRange)
    dataRange.forEach((week) => {
        let weekQuestionScores = []
        week.uniqueDailyQuestions.forEach((uniqueDailyQuestion) => {
            let questionScoreArray = []
            week.dailyQuestionsLogs.forEach(dailyQuestionLog => {
                // console.log(dailyQuestionLog.log.questions)
                if (dailyQuestionLog.log != null) {
                    const index = dailyQuestionLog.log.questions.findIndex(question => {
                        return question === uniqueDailyQuestion
                    })
                    if (index != -1) {
                        questionScoreArray.push(dailyQuestionLog.log.scores[index])

                    } else {
                        questionScoreArray.push(null)
                    }
                } else {
                    questionScoreArray.push(null)

                }

            });
            weekQuestionScores.push({
                question: uniqueDailyQuestion,
                scores: questionScoreArray,

            })
            // console.log("::",uniqueDailyQuestion,questionScoreArray)


        });
        week.questionsWeekScores = weekQuestionScores
    });

    return dataRange
}


const makeGraphDatasets = (dataRange) => {
    dataRange.forEach((week) => {
        let colorIndex = 0
        let datasets = []
        console.log(week)
        week.questionsWeekScores.forEach((question, index) => {
            colorIndex += 1;
            const dataset = {
                label: question.question ,
                backgroundColor: colorScheme[colorIndex],
                data: question.scores,
            };
            datasets.push(dataset);
        });
        week.datasets = datasets
        week.filteredDatasets =datasets
    })
    return dataRange
}

const makeLabels = (dataRange)=>{

    dataRange.forEach((week) => {
        let labels = [];
        week.dailyQuestionsLogs.forEach((dailyQuestionLog) => {
            const date =
            dailyQuestionLog.date.locale("nl").format("dddd") +
                " " +
                dailyQuestionLog.date.format("DD-MM-YYYY");
            labels.push(date);
        });
        week.labels = labels;
    });

    return dataRange;

}

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

const makeQuestionCharts = (dateRange) => {
    dateRange.forEach((week) => {
        makeChart(
            week.labels,
            week.filteredDatasets,
            "test_" + week.weekNr,
            week.weekNr
        );
    });
};



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


const filterDataRangeForCheckBoxes =(weekDatas,questions)=>{

    const labelsToRemove = questions
    weekDatas.forEach((weekData) => {
        const filteredWeekDatasets = []
        weekData.datasets.forEach(label => {
            let keepData = false
            labelsToRemove.forEach(labelToRemove => {
                    if(label.label == labelToRemove){
                        keepData = true
                    }
            });
            if(keepData == true){
                filteredWeekDatasets.push(label)
            }
        });
        weekData.filteredDatasets = filteredWeekDatasets
    });
    makeQuestionCharts(weekDatas);


}



const generateDailyQuestionsGraphs = (startDate, endDate) => {


    console.log("generateDailyQuestionsGraphs called")
    console.log("daily questions")
    console.log(dailyQuestions)

    const startDateStr = startDate
    const endDateStr = endDate

    const startDateMoment = moment(startDateStr, "YYYY-[W]WW").weekday(1);
    const endDateMoment = moment(endDateStr, "YYYY-[W]WW").weekday(8);

    const filteredDailyQuestionsForDate = filterDailyQuestionsForDate(
        startDateMoment,
        endDateMoment
    );
    console.log("filteredDailyQuestionsForDate")
    console.log(filteredDailyQuestionsForDate)

    const uniqueQuestions = getUniqueQuestions(filteredDailyQuestionsForDate)
    console.log("uniqueQuestions")
    console.log(uniqueQuestions)

    const dailyDataRange = makeDailyDataRange(uniqueQuestions, startDateStr, endDateStr)
    console.log("dailyDataRange")
    console.log(dailyDataRange)

    const dailyQuestionsLogDataRange = addDailyQuestionsLogToDateRange(dailyDataRange, filteredDailyQuestionsForDate)
    console.log("dailyQuestionsLogDataRange")
    console.log(dailyQuestionsLogDataRange)

    const calcedDailyQuestionsAverages = calcDailyQuestionsAverages(dailyQuestionsLogDataRange)
    console.log("calcedDailyQuestionsAverages")
    console.log(calcedDailyQuestionsAverages)

    const graphDatasets = makeGraphDatasets(calcedDailyQuestionsAverages)
    console.log("graphDatasets")
    console.log(graphDatasets)

    const graphLabels = makeLabels(graphDatasets)
    console.log("graphLabels")
    console.log(graphLabels)

    const checkBoxes = document.getElementById("checkBoxes")
    if(checkBoxes.innerHTML !=""){
        checkBoxes.innerHTML = ""

    }

    makeGroupCheckBoxes('mainCheckBoxes',uniqueQuestions,"Filter vragen:")
    makeQuestionCharts(graphLabels)

    document.getElementById('checkBoxes').addEventListener('change',()=>{
        const uniqueQuestionsChecked = uniqueQuestions.filter(checkBoxId =>
            document.getElementById(checkBoxId).checked ==true
            )


            filterDataRangeForCheckBoxes(graphLabels,uniqueQuestionsChecked)

    })



}

export default generateDailyQuestionsGraphs
