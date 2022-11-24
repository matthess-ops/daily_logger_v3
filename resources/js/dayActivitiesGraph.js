import moment from "moment";
import Chart from "chart.js/auto";
import { forEach } from "lodash";


// huge error detected because stuff is saved as an object, the object
//doestn have to be return after modification

//colours array
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

//filter the dailyActivities logs for logs with a created_at date
//between startDate and endDate
const filterDailyActivitiesForDate = (startDate, endDate) => {
    const filtered = dailyActivities.filter((log) => {
        if (
            moment(log.created_at) >= startDate &&
            moment(log.created_at) <= endDate
        ) {
            return log;
        }
    });

    return filtered;
};

//Get from all the inputed dailyActivities logs the unique scaled
//and main activities
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
//create for each week between the inputted startDate and endDate
// an object. return an array of these object, where each object
//represents an week
const makeWeekActivitiesDataRange = (
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

    const weekDiff = intEndWeek - intStartWeek + 1;

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
    return dateRange;
};
// add to each week object the required 7 activities log. If a week
// doenst have an required log null is added
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

//calculate for each unique main activity the daily total
//minutes spend on this unique main activity. This is done for each week object
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
//calculate for each unique scaled activity the daily average score
//. This is done for each week object
const calcWeekScaledActivityData = (dateRange) => {
    dateRange.forEach((week) => {
        let averageScores = [];
        week.uniqueScaledActivities.forEach((uniqueScaledActivity) => {
            let dayScaledData = [];
            week.activityLogs.forEach((activityLog) => {
                if (activityLog.log != null) {
                    const scaledActivities =
                        activityLog.log.scaled_activities[0];
                    //since the log score array and the log scaledActivities arrays are seperate arrays
                    //the index of the uniqueScaledActivity in log scaledActivities needs to determined, with this
                    //index the correct score can be plucked from the scores array.
                    //this is needed since an user can add an remove scaledActivities therefore
                    //the order of the scaled activites in the logs might be different from each other.
                    //also some unique scaled activities might not exist in all arrays
                    const arrayIndexOfuniqueScaledActivity =
                        scaledActivities.findIndex(
                            (inputUniqueScaledActivity) => {
                                return (
                                    inputUniqueScaledActivity ==
                                    uniqueScaledActivity
                                );
                            }
                        );
                    //unique scaled activity is found in log scaledActivities array
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
                        //because of the check zerohits can not be zero, but for ease of mind i added this
                        if (hits == 0) {
                            dayScaledData.push(0);
                            console.log("ERROR: hits is zero");
                        } else {
                            dayScaledData.push(totalScore / hits);
                        }
                    }
                } else {
                    // the scaled activity is not found in the log return zero, this results in a zero bar in the graph
                    dayScaledData.push(0);
                }
            });
            averageScores.push(dayScaledData);
        });
        week.scaledActivityAverages = averageScores;
    });
    return dateRange;
};

//convert the calculated scaled activity scores and main activity total minutes to
// chartjs datasets
// main activities are a stacked bar chart
//while scaled activities are seperate bar charts
const generateWeekDatasets = (dateRange) => {
    dateRange.forEach((week) => {
        let colorIndex = 0;
        let stackIndex = 0;
        let datasets = [];
        week.mainActivityTotal.forEach((mainActivityTot, index) => {
            colorIndex += 1;
            const mainActSet = {
                // since null contain no information for the user, null is replace by a string
                label:
                    week.uniqueMainActivities[index] == null
                        ? "niet ingevuld"
                        : week.uniqueMainActivities[index],
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
        week.filteredDatasets = datasets;
    });
    return dateRange;
};

//genrate for each column of the week graphs the label.
// format is dutch day name plus DD-MM-YYYY

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
// make an chart.
const makeChart = (chartLabels, chartDatasets, chartName, weeknr) => {
    let chartStatus = Chart.getChart(chartName);
    // if chart with chartname exists destroy it
    if (chartStatus != undefined) {
        chartStatus.destroy();
    }
    // make new chart canvas
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

// make for each week in dateRange an seperate chart
const makeWeekActivityCharts = (dateRange) => {
    dateRange.forEach((week) => {
        console.log("graph weeknr ",week.weekNr)
        console.log("addd remarks stuff in here")
        makeChart(
            week.labels,
            week.filteredDatasets,
            "test_" + week.weekNr,
            week.weekNr
        );
        makeRemarks(week)
    });
};

const makeRemarks = (week)=>{
    const weekRemarksDiv = document.createElement('div')
    weekRemarksDiv.id = week.weekNr
    week.questionRemarks.forEach(remark => {
        if(remark.remark != ""){
            const remarkP = document.createElement('p')
            remarkP.classList.add('text-left')
            remarkP.innerText = remark.date.locale("nl").format("dddd DD-MM-YYYY") +
            ": " + remark.remark
            weekRemarksDiv.appendChild(remarkP)
        }

    });
    document.getElementById("chartDiv").appendChild(weekRemarksDiv)


}
// create the scaled activities and main activities checkboxes
const makeGroupCheckBoxes = (divId, checkBoxNames, title) => {
    const groupDiv = document.createElement("div");
    groupDiv.id = divId;
    const checkBoxDiv = document.getElementById("checkBoxes");
    checkBoxDiv.appendChild(groupDiv);
    const divOfInterest = document.getElementById(divId);
    checkBoxDiv.appendChild(divOfInterest);
    const newTitle = document.createElement("h4");
    newTitle.innerText = title;
    divOfInterest.appendChild(newTitle);
    checkBoxNames.forEach((checkBoxName, index) => {
        const newLabel = document.createElement("label");
        newLabel.setAttribute("for", checkBoxName);
        newLabel.innerHTML = checkBoxName;
        const newCheckbox = document.createElement("input");
        newCheckbox.setAttribute("type", "checkbox");
        newCheckbox.setAttribute("id", checkBoxName);
        newCheckbox.setAttribute("checked", true);
        newCheckbox.setAttribute("value", checkBoxName);
        const br = document.createElement("br");
        divOfInterest.appendChild(newLabel);
        divOfInterest.appendChild(newCheckbox);
        divOfInterest.appendChild(br);
    });
};


//filter the week datasets for the the scaledActivities and mainActivities
// that have a checked checkbox

const filterDataRangeForCheckBoxes = (
    weekDatas,
    checkBoxes,

) => {
    const labelsToKeep = checkBoxes
    weekDatas.forEach((weekData) => {
        const filteredWeekDatasets = [];
        weekData.datasets.forEach((label) => {
            let keepData = false;
            labelsToKeep.forEach((labelToKeep) => {
                if (label.label == labelToKeep) {
                    keepData = true;
                }
            });
            if (keepData == true) {
                filteredWeekDatasets.push(label);
            }
        });
        weekData.filteredDatasets = filteredWeekDatasets;
    });
    makeWeekActivityCharts(weekDatas);
};

const addRemarks = (dateRange)=>{

    dateRange.forEach(week => {
        const fullQuestionLogs = dailyQuestions.filter((log) => {
            if (
                moment(log.date_today) >= week.mondayDate &&
                moment(log.date_today) <= week.sundayDate
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
        // console.log("questionLogs")
        // console.log(questionRemarks)
        week.questionRemarks = questionRemarks
    });

    // return dateRange

}

///main function that execute all the needed functions
const generateDailyActivitiesGraphs = (startDate, endDate) => {
    const startDateStr = startDate;
    const endDateStr = endDate;
    //since you want full weeks the correct startDate is the monday of the week of interest
    //the same of endDate
    const startDateMoment = moment(startDateStr, "YYYY-[W]WW").weekday(1);
    const endDateMoment = moment(endDateStr, "YYYY-[W]WW").weekday(8);

    const filtedDailyActivitiesLogs = filterDailyActivitiesForDate(
        startDateMoment,
        endDateMoment
    );

    const [uniqueMainActivities, uniqueScaledActivities] =
        getUniqueScaledAndMainActivities(filtedDailyActivitiesLogs);

    // console.log("uniqueMainActivities")
    // console.log(uniqueMainActivities,uniqueScaledActivities)

    const weekActivtyDateRange = makeWeekActivitiesDataRange(
        uniqueMainActivities,
        uniqueScaledActivities,
        startDateStr,
        endDateStr
    );
    // console.log("weekActivtyDateRange")
    // console.log(weekActivtyDateRange)
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
    addRemarks(dateRangeLabels)
    makeWeekActivityCharts(dateRangeLabels);

    document.getElementById("checkBoxes").innerHTML = "";
    makeGroupCheckBoxes(
        "mainCheckBoxes",
        uniqueMainActivities.map((activity) =>
            activity !== null ? activity : "niet ingevuld"
        ),
        "Filter Main Activities"
    );
    makeGroupCheckBoxes(
        "scaledCheckBoxes",
        uniqueScaledActivities,
        "Filter geschaalde activiteiten"
    );


    document.getElementById("checkBoxes").addEventListener("change", () => {
        const checkBoxes = uniqueMainActivities
            .map((activity) => (activity !== null ? activity : "niet ingevuld"))
            .concat(uniqueScaledActivities)
            .filter(
                (checkBoxId) =>
                    document.getElementById(checkBoxId).checked == true
            );
        filterDataRangeForCheckBoxes(dateRangeLabels, checkBoxes);
    });
};

export default generateDailyActivitiesGraphs;


