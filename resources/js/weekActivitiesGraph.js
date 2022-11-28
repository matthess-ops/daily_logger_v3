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
// filter the daily activities logs for startdate and endDate
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

//get the unique scaled and ain activities of the daily activities logs of interest
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

// create for between startDate and endDate the 8 week per graph objects
const makeDataRange = (startDate, endDate) => {
    let chunkArray = [];
    let graphArray = [];
    let weekStartDate = startDate.clone();
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
// add for each week in the 8 week graph objects te daily activities log belonging to
// that week
const addLogsToDataRange = (graphsDateRange, filteredLogs) => {

    graphsDateRange.forEach((dataRange) => {
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

    return graphsDateRange;
};
//calculate for each uniqueMainActivity foreach week in the 8 week graph object
//the week total in hours for the uniqueMainActivity.
const calculateGraphDataRangeMainActivityTotals =(graphDateRange,uniqueMainActivities)=>{
    let formattedData =[]
    graphDateRange.forEach(graph => {
        let mainActCounts = []
        uniqueMainActivities.forEach(mainActivity => {
        let graphActivityWeekTotals = []
        graph.forEach(week => {
                let weekActivityTotal = 0
                week.activitiesLogs.forEach(log => {
                    log.main_activities.forEach(activity => {
                        if(activity ==mainActivity ){
                            weekActivityTotal =weekActivityTotal+1 //each weekactivity counted is 15 minutes
                        }
                    });
                });
                graphActivityWeekTotals.push((weekActivityTotal*15)/60) // convert the minutes to hours
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

const makeRemarks = (week8Graph,index)=>{
    const week8GraphRemarksDiv = document.createElement('div')

    week8GraphRemarksDiv.id = index
    let remarksString  =""
    week8Graph.questionRemarks.forEach(remark => {
        if(remark.remark != ""){
            const remarkString = remark.date.locale("nl").format("dddd DD-MM-YYYY") +
            ": " + remark.remark
            remarksString +='<p>'+remarkString+'</p>'
        }

    });

    const htmlCodeBlock =

    '<div id="accordion">'+
    '<div class="card">'+
    '<div class="card-header" id="headingOne">'+
    '<h5 class="mb-0">'+
    ' <button class="btn btn-link" data-toggle="collapse" data-target="#collapse' +index+'" aria-expanded="true"'+
    'aria-controls="collapseOne">'+
    'Clienten opmerkingen:'+
    '</button>'+
    '</h5>'+
    '</div>'+

    '<div id="collapse' +index+'" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">'+
    '<div class="card-body">'+
  
    remarksString+
    '</div>'+
    '</div>'+
    '</div>'+
    
    '</div>'
    week8GraphRemarksDiv.innerHTML =  htmlCodeBlock

    document.getElementById("chartDiv").appendChild(week8GraphRemarksDiv)

}


//calculate for each uniqueScaledActivity foreach week in the 8 week graph object
//the weekly average score for the uniqueScaledActivity
const calculateGraphDataRangeScaledActivityAverage = (graphDateRange,uniqueScaledActivities)=>{

    graphDateRange.forEach(graph => {
        let scaledActAverages = []
        uniqueScaledActivities.forEach(scaledActivity => {
        let graphScaledAverages= []
        graph.weekData.forEach(week => {
                let weekScaledActivityCount = 0
                let weekScaledActivityTotal = 0
                let hits = 0;
                let zeroHits = 0;
                let nullHits = 0;
                let totalScore = 0;
                week.activitiesLogs.forEach(log => {
                    //find the name index of the uniquescaledAcivity in scaledActivityLog name array
                    //with the index the score for the unqueScaledActivity can be indexed from the scaledActivityLog score array
                    const indexOfScaledActivity = log.scaled_activities[0].findIndex((logScaledActivity)=>{
                        return logScaledActivity ==scaledActivity
                    })

                    if(indexOfScaledActivity != -1){
                        log.scaled_activities_scores.forEach(scoreArray => {

                            if(scoreArray[indexOfScaledActivity] === 0){
                                zeroHits +=1
                            }
                            if(scoreArray[indexOfScaledActivity] === null){
                                nullHits +=1
                            }

                            if(scoreArray[indexOfScaledActivity] !== 0 && scoreArray[indexOfScaledActivity] !== null){
                                hits = hits + 1;
                                totalScore =
                                    totalScore +
                                    scoreArray[indexOfScaledActivity]
                            }


                            weekScaledActivityTotal =weekScaledActivityTotal+ scoreArray[indexOfScaledActivity]
                            weekScaledActivityCount = weekScaledActivityCount+1
                        });
                    }

                });
                const scaledActivityWeekScore = totalScore/hits

                // const scaledActivityWeekScore = weekScaledActivityTotal/weekScaledActivityCount
                graphScaledAverages.push(scaledActivityWeekScore)
            });
            scaledActAverages.push({
                scaledActivity: scaledActivity,
                averageScores:graphScaledAverages
            })


        });
        graph.scaledActivitesScores = scaledActAverages

    });
    return graphDateRange
}

// convert the unique mainactivity total minutes array to chartjs competabile dataset
// convert the unique scaledactivity average scores array to chartjs compatible dataset
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

//generate for each week column in all 8 week graphs the column label
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


// create chartjs chart
const makeChart = (chartLabels, chartDatasets, chartName) => {
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


// create for each 8 week object in graphDateRange an chart
const makeWeekActivityCharts = (graphDateRange) => {
    graphDateRange.forEach((graph,index) => {
        makeChart(
            graph.labels,
            graph.filteredDatasets,
            "test_" + graph.labels,
            graph.labels
        );
        makeRemarks(graph,index)

    });
};

//function used to create uniqueMainActivities and uniqueScaledActivities checkboxes
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

//filter graphDateRange data for the checkedBoxes.
const filterDataRangeForCheckBoxes =(graphDateRange,checkedBoxes)=>{

    const labelsToKeep = checkedBoxes
    graphDateRange.forEach((weekData) => {
        const filtedWeekDatasets = []
        weekData.datasets.forEach(label => {
            let keepData = false
            labelsToKeep.forEach(labelToRemove => {
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
    makeWeekActivityCharts(graphDateRange);


}

const addRemarks = (dateRange)=>{
    console.log("this sis the daterange")
    console.log(dateRange)
    dateRange.forEach(week8graph => {
        const firstWeekMonday = moment(week8graph.labels[0],"YYYY-WW")
        const lastWeekSunday = moment(week8graph.labels[week8graph.labels.length-1],"YYYY-WW").day(7)

        // console.log(firstWeekMonday,lastWeekMonday)
        const fullQuestionLogs = dailyQuestions.filter((log) => {
            if (
                moment(log.date_today) >= firstWeekMonday &&
                moment(log.date_today) <= lastWeekSunday
            ) {
                return log;
            }
        });
        const questionRemarks = fullQuestionLogs.map((log)=>{
            return {
                date:moment(log.date_today),
                remark: log.client_remark

            }

        })
  
        week8graph.questionRemarks = questionRemarks
    });


}


const generateWeeklyActivitiesGraphs = (startDate, endDate) => {
    console.log("this should not be lauched")
    const startDateStr = startDate;
    const endDateStr = endDate;
    // convert startDate and endDate to moment objects
    const startDateMoment = moment(startDateStr, "YYYY-[W]WW").weekday(1);
    const endDateMoment = moment(endDateStr, "YYYY-[W]WW").weekday(8);
    //filter daily activities logs for startDate and endDate
    const filteredDailyActivitiesLogs = filterDailyActivitiesForDate(
        startDateMoment,
        endDateMoment
    );
   //get the unique main activities and unique scaled activities
    const [uniqueMainActivities, uniqueScaledActivities] =
        getUniqueScaledAndMainActivities(filteredDailyActivitiesLogs);

    //for startDateMoment and between endateMoment create for each 8 weeks an object and
    // add these to the daterange array
    const graphDataRange = makeDataRange(startDateMoment, endDateMoment);
    // console.log("graphdatrange");
    // console.log(graphDataRange);
    const graphDataRangeLogs = addLogsToDataRange(
        graphDataRange,
        filteredDailyActivitiesLogs
    );
    // console.log("graphDataRangeLogs");
    // console.log(graphDataRangeLogs);

    const calculatedGraphDataRangeMainActivityTotals = calculateGraphDataRangeMainActivityTotals(graphDataRangeLogs,uniqueMainActivities)
    // console.log("calculatedGraphDataRangeMainActivityTotals")
    // console.log(calculatedGraphDataRangeMainActivityTotals)

    const calculatedGraphDataRangeScaledActivityAverage= calculateGraphDataRangeScaledActivityAverage(calculatedGraphDataRangeMainActivityTotals,uniqueScaledActivities)
    // console.log("calculatedGraphDataRangeScaledActivityAverage")
    // console.log(calculatedGraphDataRangeScaledActivityAverage)
    const graphDatasets = generateGraphDatasets(calculatedGraphDataRangeScaledActivityAverage)
    // console.log("graphDatasets")
    // console.log(graphDatasets)

    const graphLabels = generateWeekActivityLabels(graphDatasets)
    addRemarks(graphLabels)
    // console.log("graphlabels")
    // console.log(graphLabels)
    //remove all the checkboxes
    makeWeekActivityCharts(graphLabels)
    document.getElementById("checkBoxes").innerHTML = ""
    //create checkboxes
    makeGroupCheckBoxes('mainCheckBoxes',uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld"),"Filter hoofdactiviteiten")
    makeGroupCheckBoxes('scaledCheckBoxes',uniqueScaledActivities,"Filter geschaalde activiteiten")

    document.getElementById('checkBoxes').addEventListener('change',()=>{


            const checkBoxes = uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld").concat(uniqueScaledActivities).filter(checkBoxId =>
                document.getElementById(checkBoxId).checked ==true
                )
            filterDataRangeForCheckBoxes(graphLabels,checkBoxes)

    })


};

export default generateWeeklyActivitiesGraphs;


