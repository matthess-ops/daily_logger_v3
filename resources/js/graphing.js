// import { forEach } from "lodash";
import moment from "moment";
import Chart from "chart.js/auto";
import { forEach } from "lodash";

console.log("dit werkt");

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

const getStartAndEndDate = () => {
    const dates = dailyActivities.map((dailyActivity) =>
        moment(dailyActivity.date_today, "YYYY-MM-DD")
    );
    const startDate = moment.min(dates);
    const endDate = moment.max(dates);

    return [startDate, endDate];
};

let weekMonthState = "week";
let activitiesQuestionsState = "activities";
let [startDate, endDate] = getStartAndEndDate();
console.log(startDate, endDate);

document
    .querySelectorAll("input[name='activitiesQuestionsRadio']")
    .forEach((input) => {
        input.addEventListener("change", () => {
            activitiesQuestionsState = input.value;
            // console.log('states',weekMonthState,activitiesQuestionsState)
            // changePickers()
        });
    });

document.querySelectorAll("input[name='weekMonthRadio']").forEach((input) => {
    input.addEventListener("change", () => {
        weekMonthState = input.value;
        // console.log('states',weekMonthState,activitiesQuestionsState)
        changePickers();
    });
});

const changePickers = () => {
    console.log("weekMonthState ", weekMonthState);
    if (weekMonthState == "week") {
        const startDateIsoWeek = moment().year() + "-W" + startDate.isoWeek();
        const endDateIsoWeek = moment().year() + "-W" + endDate.isoWeek();

        // const test = moment("2022-01-12","YYYY-MM-DD").isoWeek().toString()
        document
            .getElementById("startWeek")
            .setAttribute("min", startDateIsoWeek.padStart(2, "0"));
        document
            .getElementById("startWeek")
            .setAttribute("max", endDateIsoWeek.padStart(2, "0"));
        document
            .getElementById("endWeek")
            .setAttribute("min", startDateIsoWeek.padStart(2, "0"));
        document
            .getElementById("endWeek")
            .setAttribute("max", endDateIsoWeek.padStart(2, "0"));
        document.getElementById("weekpicker").classList.remove("d-none");
        document.getElementById("monthpicker").classList.add("d-none");
    }
    if (weekMonthState == "month") {
        // console.log("startDateMonth",startDateMonth)

        const startDateMonth = moment().year() + "-" + startDate.format("MM");
        const endDateMonth = moment().year() + "-" + startDate.format("MM");
        document
            .getElementById("startMonth")
            .setAttribute("min", startDateMonth);
        document.getElementById("startMonth").setAttribute("max", endDateMonth);
        document.getElementById("endMonth").setAttribute("min", startDateMonth);
        document.getElementById("endMonth").setAttribute("max", endDateMonth);
        document.getElementById("weekpicker").classList.add("d-none");
        document.getElementById("monthpicker").classList.remove("d-none");
    }
};

const makeGraph = () => {
    document.getElementById("makeGraph").addEventListener("click", () => {
        const startWeekValue = document.getElementById("startWeek").value;
        const endWeekValue = document.getElementById("endWeek").value;
        if (startWeekValue != "" && endWeekValue != "") {
            document
                .getElementById("startEndWeekEmpty")
                .classList.add("d-none");

            console.log("make the graph");
            console.log("week start and end ", startWeekValue, endWeekValue);
        } else {
            document
                .getElementById("startEndWeekEmpty")
                .classList.remove("d-none");
        }

        console.log("startWeekvalue is ", startWeekValue);
    });
};

makeGraph();

const filterDailyActivitiesForDate = (startDate, endDate) => {
    const filtered = dailyActivities.filter((log) => {
        if (
            moment(log.created_at) >= moment(startDate, "YYYY-MM-DD") &&
            moment(log.created_at) <= moment(endDate, "YYYY-MM-DD")
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
const makeWeekActivitiesDataRange = (
    uniqueMainActivities,
    uniqueScaledActivities
) => {
    const startWeekValue = document.getElementById("startWeek").value;
    const endWeekValue = document.getElementById("endWeek").value;
    const intStartWeek = parseInt(startWeekValue.split("W")[1]);
    const intEndWeek = parseInt(endWeekValue.split("W")[1]);
    const startYear = startWeekValue.split("W")[0].substring(0, 4);
    const endYear = endWeekValue.split("W")[0].substring(0, 4);

    const weekDiff = intEndWeek - intStartWeek;

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


const generateWeeklyActivitiesGraphs = ()=>{

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

    //create the main and scaled activity boxes
    // make listeners for the checboxes
    //on change boxes get the main en scaled filter de data

    const dateRangeLabels = generateWeekActivityLabels(dateRangeDatasets);
    makeWeekActivityCharts(dateRangeLabels);
    // console.log(dateRangeLabels)
    makeGroupCheckBoxes('mainCheckBoxes',uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld"))
    makeGroupCheckBoxes('scaledCheckBoxes',uniqueScaledActivities)

    document.getElementById('checkBoxes').addEventListener('change',()=>{
        console.log('change registed')
        const mainActivitiesChecked = uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld").filter(checkBoxId =>
            document.getElementById(checkBoxId).checked ==true
            )

            const scaledActivitiesChecked = uniqueScaledActivities.filter(checkBoxId =>
                document.getElementById(checkBoxId).checked ==true
                )
            console.log("main acts ",mainActivitiesChecked)
            console.log("scaled acts ",scaledActivitiesChecked)
            filterDataRangeForCheckBoxes(dateRangeLabels,mainActivitiesChecked,scaledActivitiesChecked)

    })





}

// generateWeekGraphs()

////////////////////////////////// monthly week activities/////////////////////

const filterActivityLogsForMonthRange = ()=>{


}


const generateMonthlyActivitiesGraphs = ()=>{

    const filteredActivityLogsForMonthRange = filterActivityLogsForMonthRange(
        "2022-10-16",
        "2022-11-09"
    );


    // const [uniqueMainActivities, uniqueScaledActivities] =
    //     getUniqueScaledAndMainActivities(filtedDailyActivitiesLogs);



    // const weekActivtyDateRange = makeWeekActivitiesDataRange(
    //     uniqueMainActivities,
    //     uniqueScaledActivities
    // );
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
    //     console.log('change registed')
    //     const mainActivitiesChecked = uniqueMainActivities.map(activity => activity !== null ? activity : "niet ingevuld").filter(checkBoxId =>
    //         document.getElementById(checkBoxId).checked ==true
    //         )

    //         const scaledActivitiesChecked = uniqueScaledActivities.filter(checkBoxId =>
    //             document.getElementById(checkBoxId).checked ==true
    //             )
    //         console.log("main acts ",mainActivitiesChecked)
    //         console.log("scaled acts ",scaledActivitiesChecked)
    //         filterDataRangeForCheckBoxes(dateRangeLabels,mainActivitiesChecked,scaledActivitiesChecked)

    // })

}



// ok ik heb een wekelijkse en maandelijkse input die changes moet ik tracken
// ook daily activities and daily questions radio input checckend indien de juiste input
// get main activities m

// generateWeekGraphs()

// const testChart = () => {
//     var ctx = document.getElementById("testchart").getContext("2d");
//     var myChart = new Chart(ctx, {
//         type: "bar",
//         data: {
//             labels: [
//                 "<  1",
//                 "1 - 2",
//                 "3 - 4",
//                 "5 - 9",
//                 "10 - 14",
//                 "15 - 19",
//                 "20 - 24",
//                 "25 - 29",
//                 "> - 29",
//             ],
//             datasets: [
//                 {
//                     label: "Employee",
//                     backgroundColor: "#caf270",
//                     data: [12, 59, 5, 56, 58, 12, 59, 87, 45],
//                     stack: "Stack 0",
//                 },
//                 {
//                     label: "Engineer",
//                     backgroundColor: "#45c490",
//                     data: [12, 59, 5, 56, 58, 12, 59, 85, 23],
//                     stack: "Stack 0",
//                 },
//                 {
//                     label: "Government",
//                     backgroundColor: "#008d93",
//                     data: [12, 59, 5, 56, 58, 12, 59, 65, 51],
//                     stack: "Stack 1",
//                     barThickness: 10,
//                     barPercentage: 1.0,
//                 },
//                 {
//                     label: "Political parties",
//                     backgroundColor: "#2e5468",
//                     data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
//                     stack: "Stack 2",
//                     barThickness: 10,

//                     barPercentage: 1.0,
//                 },
//             ],
//         },
//         options: {
//             plugins: {
//                 title: {
//                     display: true,
//                     text: "Chart.js Bar Chart - Stacked",
//                 },
//             },
//             responsive: true,
//             scales: {
//                 x: {
//                     stacked: true,
//                 },
//                 y: {
//                     stacked: true,
//                 },
//             },
//         },
//     });
// };
