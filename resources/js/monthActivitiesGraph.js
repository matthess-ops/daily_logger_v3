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

const filterDailyActivitiesForDate = (startDate, endDate) => {
    const filtered = dailyActivities.filter((log) => {
        if (
            moment(log.created_at) >= startDate &&
            moment(log.created_at) <= endDate
        ) {
            return log;
        }
    });
    // console.log("nbon filted activities ", dailyActivities.length)
    // console.log("filted array length activities ",filtered.length)
    // console.log(filtered)
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
//rekenin ghouden met jaar wisseling
const makeMonthActivitiesDataRange = (
    uniqueMainActivities,
    uniqueScaledActivities,
    startDate,
    endDate
) => {

    const startWeekValue = startDate;

    const endWeekValue = endDate;
    const intStartWeek = parseInt(startWeekValue.split("W")[1]);
    const intEndWeek = parseInt(endWeekValue.split("W")[1]);
    const startYear = startWeekValue.split("W")[0].substring(0, 4);
    const endYear = endWeekValue.split("W")[0].substring(0, 4);

    const weekDiff = (intEndWeek - intStartWeek)+1;

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
            activityLogs: null,
            questionLogs: null,
            mainActivityTotal: null,
            scaledActivityAverages: null,
            uniqueMainActivities: uniqueMainActivities,
            uniqueScaledActivities: uniqueScaledActivities,
            datasets: null,
            labels: null,
            filteredDatasets: null,
        };
        dateRange.push(newWeek);
    }
    // console.log(dateRange)
    return dateRange;
};

const addActivityLogsToWeekDateRange = (dateRange, filtedActivitiesLogs) => {
    dateRange.forEach((week) => {
        let logs = [];
        for (let i = 0; i < 7; i++) {
            const date = week.mondayDate.clone().add(i, "days");
            const thisLog = null;
            filtedActivitiesLogs.forEach((log) => {
                if (log.date_today == date.format("YYYY-MM-DD")) {
                    thisLog = log;
                }
            });

            logs.push({
                date: date,
                log: thisLog,
            });
        }
        week.activityLogs = logs;
    });
    return dateRange;
};

const calcWeekMainActivityData = (dateRange) => {
    dateRange.forEach((week) => {
        let uniqueMainActivitiesTotals = [];
        week.uniqueMainActivities.forEach((uniqueMainActivity) => {
            let weekUniqueActivityData = [];
            week.activityLogs.forEach((activityLog) => {
                let uniqueActivityCountInLog = 0;
                if (activityLog.log != null) {
                    activityLog.log.main_activities.forEach((mainActivity) => {
                        if (mainActivity == uniqueMainActivity) {
                            uniqueActivityCountInLog =
                                uniqueActivityCountInLog + 1;
                        }
                    });
                }
                weekUniqueActivityData.push(uniqueActivityCountInLog * 15);
            });

            uniqueMainActivitiesTotals.push(weekUniqueActivityData);
        });

        week.mainActivityTotal = uniqueMainActivitiesTotals;
    });
    return dateRange;
};

const calcWeekScaledActivityData = (dateRange) => {
    dateRange.forEach((week) => {
        let averageScores = [];
        week.uniqueScaledActivities.forEach((uniqueScaledActivity) => {
            let dayScaledData = [];
            week.activityLogs.forEach((activityLog) => {
                // console.log(activityLog.date.format('dddd'))
                if (activityLog.log != null) {
                    // console.log('this moet toch kunnen ',activityLog.log.scaled_activities[0])
                    const scaledActivities =
                        activityLog.log.scaled_activities[0];
                    const arrayIndexOfuniqueScaledActivity =
                        scaledActivities.findIndex(
                            (inputUniqueScaledActivity) => {
                                return (
                                    inputUniqueScaledActivity ==
                                    uniqueScaledActivity
                                );
                            }
                        );
                    if (arrayIndexOfuniqueScaledActivity != -1) {
                        let hits = 0;
                        let zeroHits = 0;
                        let totalScore = 0;
                        activityLog.log.scaled_activities_scores.forEach(
                            (activityScores) => {
                                if (
                                    activityScores[
                                        arrayIndexOfuniqueScaledActivity
                                    ] != 0
                                ) {
                                    hits = hits + 1;
                                    totalScore =
                                        totalScore +
                                        activityScores[
                                            arrayIndexOfuniqueScaledActivity
                                        ];
                                } else {
                                    zeroHits = zeroHits + 1;
                                }
                            }
                        );
                        dayScaledData.push(totalScore / hits);
                    }
                } else {
                    dayScaledData.push(null);
                }
            });
            averageScores.push(dayScaledData);
        });
        week.scaledActivityAverages = averageScores;
    });
    return dateRange;
};

const generateWeekDatasets = (dateRange) => {
    // console.log(dateRange);
    dateRange.forEach((week) => {
        let colorIndex = 0;
        let stackIndex = 0;
        let datasets = [];

        ////main activity stuff

        // label: scaledActivityScore.scaledActivity,
        // backgroundColor: colorScheme[index],
        // data: scaledActivityScore.aveScoresForDateRange,
        // stack: "Stack "+(index+1),
        // barThickness: 10,
        // barPercentage: 1.0,
        // yAxisID: 'y1',

        week.mainActivityTotal.forEach((mainActivityTot, index) => {
            colorIndex += 1;
            const mainActSet = {
                label: week.uniqueMainActivities[index] ==null?"niet ingevuld":week.uniqueMainActivities[index],
                backgroundColor: colorScheme[colorIndex],
                data: mainActivityTot,
                stack: "Stack 0",
                yAxisID: "y",
            };
            datasets.push(mainActSet);
        });
        week.scaledActivityAverages.forEach((scaledActivityAve, index) => {
            colorIndex += 1;
            stackIndex += 1;
            const scaledActSet = {
                label: week.uniqueScaledActivities[index],
                backgroundColor: colorScheme[colorIndex],
                data: scaledActivityAve,
                stack: "Stack " + (stackIndex + 1),
                yAxisID: "y1",
            };
            datasets.push(scaledActSet);
        });

        week.datasets = datasets;
        week.filteredDatasets =datasets
    });
    return dateRange;
};

const generateWeekActivityLabels = (dateRange) => {
    dateRange.forEach((week) => {
        let labels = [];
        week.activityLogs.forEach((activityLog) => {
            const date =
                activityLog.date.locale("nl").format("dddd") +
                " " +
                activityLog.date.format("DD-MM-YYYY");
            labels.push(date);
        });
        week.labels = labels;
    });

    return dateRange;
};

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

const makeWeekActivityCharts = (dateRange) => {
    dateRange.forEach((week) => {
        makeChart(
            week.labels,
            week.filteredDatasets,
            "test_" + week.weekNr,
            week.weekNr
        );
    });
};

const makeGroupCheckBoxes =(divId,checkBoxNames)=>{
    const divOfInterest = document.getElementById(divId)
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

const listenToCheckBoxChanges = (divId,checkBoxIds)=>{

    document.getElementById(divId).addEventListener('change',()=>{
        const checkedBoxes =checkBoxIds.filter(checkBoxId =>
            document.getElementById(checkBoxId).checked ==true
            )
        return checkedBoxes
    })

}



const test = () => {
    const filtedDailyActivitiesLogs = filterDailyActivitiesForDate(
        "2022-10-16",
        "2022-11-09"
    );


    const [uniqueMainActivities, uniqueScaledActivities] =
        getUniqueScaledAndMainActivities(filtedDailyActivitiesLogs);

    const weekActivtyDateRange = makeWeekActivitiesDataRange(
        uniqueMainActivities,
        uniqueScaledActivities
    );
    const dateRangeWithLogs = addActivityLogsToWeekDateRange(
        weekActivtyDateRange,
        filtedDailyActivitiesLogs
    );
    const dateRangeMainActivityTotals =
        calcWeekMainActivityData(dateRangeWithLogs);
    const dataRangeScaledAveraveScores = calcWeekScaledActivityData(
        dateRangeMainActivityTotals
    );
    const dateRangeDatasets = generateWeekDatasets(
        dataRangeScaledAveraveScores
    );

    const dateRangeLabels = generateWeekActivityLabels(dateRangeDatasets);
    // console.log(dateRangeLabels)
    // makeChart(dateRangeLabels[0].labels,dateRangeLabels[0].datasets,"test",10)
    makeWeekActivityCharts(dateRangeLabels);
};

//  test();


// makeGroupCheckBoxes('mainCheckBoxes',["programeren","lezen","koken"])
// makeGroupCheckBoxes('scaledCheckBoxes',["pijn","druk","verdrietig"])
// listenToCheckBoxChanges('mainCheckBoxes',["programeren","lezen","koken"])

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
///
const generateMonthlyActivitiesGraphs = (startDate,endDate)=>{

    const startDateStr= startDate
    const endDateStr =endDate

    const startDateMoment = moment(startDateStr, "YYYY-[W]WW").weekday(1);
    const endDateMoment = moment(endDateStr, "YYYY-[W]WW").weekday(8);

    const filtedDailyActivitiesLogs = filterDailyActivitiesForDate(
        startDateMoment,
        endDateMoment 
    );

 
    const [uniqueMainActivities, uniqueScaledActivities] =
        getUniqueScaledAndMainActivities(filtedDailyActivitiesLogs);


    const monthActivityDateRange = makeMonthActivitiesDataRange(
        uniqueMainActivities,
        uniqueScaledActivities,
        startDateStr,
        endDateStr
    );

    console.log('monthActivityDateRange')
    console.log(monthActivityDateRange)



    // const dateRangeWithLogs = addActivityLogsToWeekDateRange(
    //     weekActivtyDateRange,
    //     filtedDailyActivitiesLogs
    // );
    // const dateRangeMainActivityTotals =
    //     calcWeekMainActivityData(dateRangeWithLogs);
    // const dataRangeScaledAveraveScores = calcWeekScaledActivityData(
    //     dateRangeMainActivityTotals
    // );
    // const dateRangeDatasets = generateWeekDatasets(
    //     dataRangeScaledAveraveScores
    // );


    // const dateRangeLabels = generateWeekActivityLabels(dateRangeDatasets);
    // makeWeekActivityCharts(dateRangeLabels);
    // makeGroupCheckBoxes('mainCheckBoxes',uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld"))
    // makeGroupCheckBoxes('scaledCheckBoxes',uniqueScaledActivities)

    // document.getElementById('checkBoxes').addEventListener('change',()=>{
    //     const mainActivitiesChecked = uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld").filter(checkBoxId =>
    //         document.getElementById(checkBoxId).checked ==true
    //         )

    //         const scaledActivitiesChecked = uniqueScaledActivities.filter(checkBoxId =>
    //             document.getElementById(checkBoxId).checked ==true
    //             )
         
    //         filterDataRangeForCheckBoxes(dateRangeLabels,mainActivitiesChecked,scaledActivitiesChecked)

    // })

}


export default generateMonthlyActivitiesGraphs