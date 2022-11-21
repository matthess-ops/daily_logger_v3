import moment from "moment";
import Chart from "chart.js/auto";
import { forEach } from "lodash";

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

const filterDailyActivitiesForDate = (startDate, endDate) => {
    const filtered = dailyActivities.filter((log) => {
        if (
            moment(log.date_today) >= startDate &&
            moment(log.date_today) <= endDate
        ) {
            return log;
        }
    });
  
    return filtered;
};

const getUniqueScaledAndMainActivities = (dailyActivities) => {
    let allMainActivities = [];
    let allScaledActivities = [];
    dailyActivities.forEach((dailyActivityLog) => {
        dailyActivityLog.main_activities.forEach((mainActivities) => {
            allMainActivities = allMainActivities.concat(mainActivities);
        });
        dailyActivityLog.scaled_activities.forEach((scaledActivities) => {
            allScaledActivities = allScaledActivities.concat(scaledActivities);
        });
    });

    const uniqueMainActivities = [...new Set(allMainActivities)];
    const uniqueScaledActivities = [...new Set(allScaledActivities)];
    return [uniqueMainActivities, uniqueScaledActivities];
};

const makeDataRange = (startDate, endDate) => {
    let chunkArray = [];
    let graphArray = [];
    let weekStartDate = startDate.clone();
    let weekEndDate = startDate.clone().add(7, "days");
    while (weekStartDate < endDate) {

        let newWeek = {
            weekStartDate: weekStartDate.clone(),
            weekEndDate: weekStartDate.clone().add(6, "days").clone(),
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

const addLogsToDataRange = (graphDataRange, filteredLogs) => {

    graphDataRange.forEach((dataRange) => {
        dataRange.forEach((week) => {
            const activitiesLogs = filteredLogs.filter((log) => {
                if (
                    moment(log.date_today) >= week.weekStartDate &&
                    moment(log.date_today) <= week.weekEndDate
                ) {
                    return log;
                }
            });
            week.activitiesLogs = activitiesLogs;
        });
    });

    return graphDataRange;
};

const calculateGraphDataRangeMainActivityTotals =(graphDataRange,uniqueMainActivities)=>{
    let formattedData =[]
    graphDataRange.forEach(graph => {
        let mainActCounts = []
        uniqueMainActivities.forEach(mainActivity => {
        let graphActivityWeekTotals = []
        graph.forEach(week => {
                let weekActivityTotal = 0
                week.activitiesLogs.forEach(log => {
                    log.main_activities.forEach(activity => {
                        if(activity ==mainActivity ){
                            weekActivityTotal =weekActivityTotal+1
                        }
                    });
                });
                graphActivityWeekTotals.push((weekActivityTotal*15)/60)
            });
            mainActCounts.push({
                activity:mainActivity,
                totals: graphActivityWeekTotals
            })

        });

        const formatData = {
            mainActTotals:mainActCounts,
            weekData:graph
        }
        formattedData.push(formatData)

    });
    return formattedData
}

const calculateGraphDataRangeScaledActivityAverage = (graphDataRange,uniqueScaledActivities)=>{

    graphDataRange.forEach(graph => {
        let scaledActAverages = []
        uniqueScaledActivities.forEach(scaledActivity => {
        let graphScaledAverages= []
        graph.weekData.forEach(week => {
                let weekScaledActivityCount = 0
                let weekScaledActivityTotal = 0
                week.activitiesLogs.forEach(log => {
                    const indexOfScaledActivity = log.scaled_activities[0].findIndex((logScaledActivity)=>{
                        return logScaledActivity ==scaledActivity
                    })

                    if(indexOfScaledActivity != -1){
                        log.scaled_activities_scores.forEach(scoreArray => {
                            weekScaledActivityTotal =weekScaledActivityTotal+ scoreArray[indexOfScaledActivity]
                            weekScaledActivityCount = weekScaledActivityCount+1
                        });
                    }
                   //find for each log the index position of the scaledActivity in .scaled_activities
                   //then loop through .scaled_activities_scores[index] and add the score
                });
                const scaledActivityWeekScore = weekScaledActivityTotal/weekScaledActivityCount
                graphScaledAverages.push(scaledActivityWeekScore)
            });
            scaledActAverages.push({
                scaledActivity: scaledActivity,
                averageScores:graphScaledAverages
            })


        });
        graph.scaledActivitesScores = scaledActAverages

    });
    return graphDataRange
}

const generateGraphDatasets = (dateRange) => {
    dateRange.forEach((graph) => {
        let colorIndex = 0;
        let stackIndex = 0;
        let datasets = [];



        graph.mainActTotals.forEach((mainActTotal, index) => {
            colorIndex += 1;
            const mainActSet = {
                label: mainActTotal.activity==null?"niet ingevuld":mainActTotal.activity,
                backgroundColor: colorScheme[colorIndex],
                data: mainActTotal.totals,
                stack: "Stack 0",
                yAxisID: "y",
            };
            datasets.push(mainActSet);
        });
        graph.scaledActivitesScores.forEach((scaledActivityScore, index) => {
            colorIndex += 1;
            stackIndex += 1;
            const scaledActSet = {
                label: scaledActivityScore.scaledActivity,
                backgroundColor: colorScheme[colorIndex],
                data: scaledActivityScore.averageScores,
                stack: "Stack " + (stackIndex + 1),
                yAxisID: "y1",
            };
            datasets.push(scaledActSet);
        });

        graph.datasets = datasets;
        graph.filteredDatasets =datasets
    });
    return dateRange;
};


const generateWeekActivityLabels = (graphDataRange) => {
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

// const footer = (tooltipItems) => {
//     let sum = 0;

//     tooltipItems.forEach(function(tooltipItem) {
//       sum += tooltipItem.parsed.y;
//       console.log("tooltip stuff ",tooltipItem)
//     });
//     return 'Total: ' + sum;
//   };


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
                    // text: "Week resultaten :" + weeknr,
                },
                // tooltip: {
                //     callbacks: {
                //         footer: footer,
                //     }
                //   },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    position: "left",
                },
                y1: {
                    stacked: true,
                    position: "right",
                },
            },
        },
    });

    myChart.update();
};

const makeWeekActivityCharts = (graphDataRange) => {
    graphDataRange.forEach((graph) => {
        makeChart(
            graph.labels,
            graph.filteredDatasets,
            "test_" + graph.labels,
            graph.labels
        );
    });
};

const testScaledScore = (graphDataRange)=>{
    let weekData = graphDataRange[0].weekData[0].activitiesLogs
    let weeksum = 0
    let weekcount = 0
    weekData.forEach(week => {
        let sum=0
        let count = 0
        let scores =week.scaled_activities_scores
        scores.forEach(score => {
            sum =sum+ score[1]
            weeksum = weeksum+ score[1]
            count =count+1
            weekcount=weekcount+1
        });
        console.log("sum and count are ",sum,count)

    });

}

const makeGroupCheckBoxes =(divId,checkBoxNames)=>{
    const divOfInterest = document.getElementById(divId)
    divOfInterest.innerHTML = ""

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

const filterDataRangeForCheckBoxes =(weekDatas,mainActivities,scaledActivities)=>{

    const labelsToRemove = [].concat(mainActivities, scaledActivities)
    weekDatas.forEach((weekData) => {
        const filtedWeekDatasets = []
        weekData.datasets.forEach(label => {
            let keepData = false
            labelsToRemove.forEach(labelToRemove => {
                    if(label.label == labelToRemove){
                        keepData = true
                    }
            });
            if(keepData == true){
                filtedWeekDatasets.push(label)
            }
        });
        weekData.filteredDatasets = filtedWeekDatasets
    });
    makeWeekActivityCharts(weekDatas);


}


const generateWeeklyActivitiesGraphs = (startDate, endDate) => {
    console.log("this should not be lauched")
    const startDateStr = startDate;
    const endDateStr = endDate;

    const startDateMoment = moment(startDateStr, "YYYY-[W]WW").weekday(1);
    const endDateMoment = moment(endDateStr, "YYYY-[W]WW").weekday(8);

    const filtedDailyActivitiesLogs = filterDailyActivitiesForDate(
        startDateMoment,
        endDateMoment
    );

    const [uniqueMainActivities, uniqueScaledActivities] =
        getUniqueScaledAndMainActivities(filtedDailyActivitiesLogs);

    const graphDataRange = makeDataRange(startDateMoment, endDateMoment);
    // console.log("graphdatrange");
    // console.log(graphDataRange);
    const graphDataRangeLogs = addLogsToDataRange(
        graphDataRange,
        filtedDailyActivitiesLogs
    );
    // console.log("graphDataRangeLogs");
    // console.log(graphDataRangeLogs);

    const calculatedGraphDataRangeMainActivityTotals = calculateGraphDataRangeMainActivityTotals(graphDataRange,uniqueMainActivities)
    // console.log("calculatedGraphDataRangeMainActivityTotals")
    // console.log(calculatedGraphDataRangeMainActivityTotals)

    const calculatedGraphDataRangeScaledActivityAverage= calculateGraphDataRangeScaledActivityAverage(calculatedGraphDataRangeMainActivityTotals,uniqueScaledActivities)
    // console.log("calculatedGraphDataRangeScaledActivityAverage")
    // console.log(calculatedGraphDataRangeScaledActivityAverage)
    const graphDatasets = generateGraphDatasets(calculatedGraphDataRangeScaledActivityAverage)
    // console.log("graphDatasets")
    // console.log(graphDatasets)

    const graphLabels = generateWeekActivityLabels(graphDatasets)
    // console.log("graphlabels")
    // console.log(graphLabels)

    makeWeekActivityCharts(graphLabels)

    makeGroupCheckBoxes('mainCheckBoxes',uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld"))
    makeGroupCheckBoxes('scaledCheckBoxes',uniqueScaledActivities)

    document.getElementById('checkBoxes').addEventListener('change',()=>{
        const mainActivitiesChecked = uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld").filter(checkBoxId =>
            document.getElementById(checkBoxId).checked ==true
            )

            const scaledActivitiesChecked = uniqueScaledActivities.filter(checkBoxId =>
                document.getElementById(checkBoxId).checked ==true
                )

            filterDataRangeForCheckBoxes(graphLabels,mainActivitiesChecked,scaledActivitiesChecked)

    })


};

export default generateWeeklyActivitiesGraphs;


