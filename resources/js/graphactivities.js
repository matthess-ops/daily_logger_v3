// what to graph
// 1: select number of main activities to graph and graph these in stacked bar chart
// 2: select number of scaled activities to graph and grap these in lines
// 3: select one main activity and graph the scaled activities

//1:
//1a: get first and last data
//2a: calc the totals of each activity for the day.
//3a: generate graph

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

const getDateRange = () => {
    const dates = dailyActivities.map((dailyActivity) =>
        moment(dailyActivity.date_today, "YYYY-MM-DD")
    );
    let earliestDate = dates[0];
    const latestDate = dates[dates.length - 1];
    const diffInDays = latestDate.diff(earliestDate, "days");
    let dateRange = [];
    for (let day = 0; day < diffInDays; day++) {
        const newdate = earliestDate.add("days", 1);
        dateRange.push(newdate.clone());
    }
    return dateRange;
};
// for each date in daterange calc total time spend on the mainActivity
const calcDailyTotalsForMainActivity = (mainActivityOfInterest, dateRange) => {
    let minutesSpendOnMainActivityForDateRange = [];

    dateRange.forEach((date) => {
        let matchedDataArray = dailyActivities.find(
            (dailyActivity) =>
                dailyActivity.date_today == date.format("YYYY-MM-DD")
        );
        if (matchedDataArray == undefined) {
            // do something here if the date doesnt have a hit
            // maybe make null
            minutesSpendOnMainActivityForDateRange.push(0);
        } else {
            let minutesSpendOnMainActivity =
                matchedDataArray.main_activities.filter(
                    (mainActivity) => mainActivity == mainActivityOfInterest
                ).length * 15;

            minutesSpendOnMainActivityForDateRange.push(
                minutesSpendOnMainActivity
            );
        }
    });
    return {
        mainActivity: mainActivityOfInterest,
        values: minutesSpendOnMainActivityForDateRange,
    };
};

const getTotalTimesForMultipleMainActivities = (
    mainActivitiesOfInterest,
    dateRange
) => {
    let mainActivitiesOfInterestResults = [];
    mainActivitiesOfInterest.forEach((mainActivityOfInterest) => {
        const timeResults = calcDailyTotalsForMainActivity(
            mainActivityOfInterest,
            dateRange
        );
        mainActivitiesOfInterestResults.push(timeResults);
    });
    // console.log('toal results ',mainActivitiesOfIntestResults)
    return mainActivitiesOfInterestResults;
};

// problem if the user removes an mainActivity from the database the color is lost from the activity table.
//however the dailyActivity results have these colors. However if an user has added and removed the same mainActivity from the table
//this results in that a mainActivity can have multiple colors in the dailyActivity results.
//step 1: get all the mainActivity and colors from the dailyActivities array
//step 2: reduce the results to  mainActivity color pairs
const getAllMainActivitiesWithAssociatedColor = () => {
    let mainActivityColorPairs = [];
    dailyActivities.forEach((dailyActivity) => {
        dailyActivity.main_activities.forEach((mainActivity, index) => {
            if (mainActivity != null) {
                mainActivityColorPairs.push(
                    mainActivity + "$" + dailyActivity.colors[index]
                );
            }
        });
    });

    const uniqueMainActivityColorPairs = [...new Set(mainActivityColorPairs)];
    const sepUniqueMainActivityColorPairs = uniqueMainActivityColorPairs.map(
        (mainActColPair) => mainActColPair.split("$")
    );

    return sepUniqueMainActivityColorPairs;
};

const addColorToMainActivitiesTotals = (mainActTotals, mainActColors) => {
    mainActTotals.forEach((mainActTotal) => {
        for (const mainActColor of mainActColors) {
            if (mainActColor[0] == mainActTotal.mainActivity) {
                mainActTotal.color = mainActColor[1];
                break;
            }
        }
    });
    return mainActTotals;
};

const convertMainActTotalsToGraphInput = (mainActTotals, dateRange) => {
    const chartLabels = dateRange.map((date) => date.format("YYYY-MM-DD"));
    let datasets = [];
    mainActTotals.forEach((mainActTotal) => {
        datasets.push({
            label: mainActTotal.mainActivity,
            backgroundColor: mainActTotal.color,
            data: mainActTotal.values,
            stack: "Stack 0",
            yAxisID: 'y',


        });
    });

    return { chartLabels, datasets };
};

// const testChart1 = (chartLabels, chartDatasets) => {
//     var ctx = document.getElementById("myChart4").getContext("2d");
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
//                 },
//                 {
//                     label: "Engineer",
//                     backgroundColor: "#45c490",
//                     data: [12, 59, 5, 56, 58, 12, 59, 85, 23],
//                 },
//                 {
//                     label: "Government",
//                     backgroundColor: "#008d93",
//                     data: [12, 59, 5, 56, 58, 12, 59, 65, 51],
//                 },
//                 {
//                     label: "Political parties",
//                     backgroundColor: "#2e5468",
//                     data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
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

const makeChart = (chartLabels, chartDatasets) => {
    let chartStatus = Chart.getChart("myChart4"); // <canvas> id
    if (chartStatus != undefined) {
        chartStatus.destroy();
        //(or)
        // chartStatus.clear();
    }

    var ctx = document.getElementById("myChart4").getContext("2d");

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
                    text: "Chart.js Bar Chart - Stacked",
                },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    position:'left',
                },
                y1: {
                    stacked: true,
                    position: 'right',
                }


            },
        },
    });

    myChart.update();
};

const createMainActivityInterface = (mainActivitiesInput) => {
    console.log(mainActivitiesInput);
    const mainActInterface = document.getElementById("interface");
    mainActivitiesInput.forEach((mainActivityInput) => {
        const newLabel = document.createElement("label");
        newLabel.setAttribute("for", "checkbox");
        newLabel.innerHTML = mainActivityInput[0];

        const newCheckbox = document.createElement("input");
        newCheckbox.setAttribute("type", "checkbox");
        newCheckbox.setAttribute("id", mainActivityInput[0]);

        const br = document.createElement("br");

        mainActInterface.appendChild(newLabel);
        mainActInterface.appendChild(newCheckbox);
        mainActInterface.appendChild(br);
    });
};


// step 2: scaled data visualisation
// 1 for each of the scaled activities calculate the average daily score
// 2 plot these as seperate bars in the graph

//1: get all the scaled activities and there colors from the database
//2: calculate for each date in daterange for each scaled activity the average
//3: plot this

//type is either scaled or main activity
const getUniqueScaledActivities = () => {
    let dailyScaledActivities = [];

    dailyActivities.forEach((dailyActivity) => {
        const scaledActivities = dailyActivity.scaled_activities[0];
        scaledActivities.forEach((scaledActivity) => {
            dailyScaledActivities.push(scaledActivity);
        });
    });
    const uniqueDailyScaledActivities = [...new Set(dailyScaledActivities)];
    return uniqueDailyScaledActivities;
};

const calcDailyAverageScaledActivitiesScore = (
    dateRange,
    uniqueDailyScaledActivities
) => {
    let scaledActivitiesAveScores = [];
    dateRange.forEach((date) => {
        dailyActivities.forEach((dailyActivity) => {
            if (dailyActivity.date_today == date.format("YYYY-MM-DD")) {
                let dailyScaledActivitiesTotalScores = new Array(
                    uniqueDailyScaledActivities.length
                ).fill(0);
                let dailyScaledActivitiesInputCounts = new Array(
                    uniqueDailyScaledActivities.length
                ).fill(0);
                uniqueDailyScaledActivities.forEach(
                    (uniqueDailyScaledActivity) => {
                        const indexOfDailyActivity =
                            dailyActivity.scaled_activities[0].findIndex(
                                (scaledActivity) =>
                                    scaledActivity == uniqueDailyScaledActivity
                            );
                        dailyActivity.scaled_activities_scores.forEach(
                            (timeSlotScoreArray) => {
                                if (
                                    timeSlotScoreArray.reduce((a, b) => a + b) >
                                    0
                                ) {
                                    dailyScaledActivitiesTotalScores[
                                        indexOfDailyActivity
                                    ] =
                                        dailyScaledActivitiesTotalScores[
                                            indexOfDailyActivity
                                        ] +
                                        timeSlotScoreArray[
                                            indexOfDailyActivity
                                        ];
                                    dailyScaledActivitiesInputCounts[
                                        indexOfDailyActivity
                                    ] =
                                        dailyScaledActivitiesInputCounts[
                                            indexOfDailyActivity
                                        ] + 1;
                                }
                            }
                        );
                    }
                );
                let dailyScaledActivitiesAverageScores = [];
                dailyScaledActivitiesTotalScores.forEach((score, index) => {
                    const count = dailyScaledActivitiesInputCounts[index];
                    const averageDailyScore = score / count;
                    dailyScaledActivitiesAverageScores.push(
                        averageDailyScore.toFixed(2)
                    );
                });

                scaledActivitiesAveScores.push(
                    dailyScaledActivitiesAverageScores
                );
                // console.log(dailyScaledActivitiesTotalScores)
                // console.log('conts',dailyScaledActivitiesInputCounts)
                // console.log(date.format("YYYY-MM-DD"),'averages',dailyScaledActivitiesAverageScores)
                // console.log(dailyScaledActivitiesTotalScores.dailyScaledActivitiesInputCounts)
            }
        });
    });
    let converted = []
    uniqueDailyScaledActivities.forEach((uniqueDailyScaledActivity,index) => {
        let newscores = []
        scaledActivitiesAveScores.forEach(scaledActivityAveScores => {
            newscores.push(scaledActivityAveScores[index])
        });
        converted.push({
            scaledActivity:uniqueDailyScaledActivity,
            aveScoresForDateRange: newscores,

        })

    });
    return converted
};

const convertDailyScaledActivitiesScoresToChartDatasets = (scaledActivityScores)=>{
    console.log('scores')
    console.log(scaledActivityScores)
    let datasets = []
    scaledActivityScores.forEach((scaledActivityScore,index) => {
   datasets.push({
        label: scaledActivityScore.scaledActivity,
        backgroundColor: colorScheme[index],
        data: scaledActivityScore.aveScoresForDateRange,
        stack: "Stack "+(index+1),
        barThickness: 10,
        barPercentage: 1.0,
        yAxisID: 'y1',

    });
    });
    return datasets
}

const checkAllButton = (dateRange, mainActivitiesPlusColor,scaledActivityChartDatasets) => {
    document.getElementById("all").addEventListener("click", () => {
        console.log("clicked button");

        mainActivitiesPlusColor.forEach((mainActivityPlusColor) => {
            document.getElementById(mainActivityPlusColor[0]).checked = true;
        });
        let checkedBoxes = [];
        mainActivitiesPlusColor.forEach((mainActivityPlusColor) => {
            if (document.getElementById(mainActivityPlusColor[0]).checked) {
                checkedBoxes.push(mainActivityPlusColor[0]);
            }
        });
        if (checkedBoxes.length > 0) {
            const totalTimesForMultipleMainActivities =
                getTotalTimesForMultipleMainActivities(checkedBoxes, dateRange);

            const mainActsTotalsColors = addColorToMainActivitiesTotals(
                totalTimesForMultipleMainActivities,
                mainActivitiesPlusColor
            );
            const { chartLabels, datasets } = convertMainActTotalsToGraphInput(
                mainActsTotalsColors,
                dateRange
            );
            // clearCanvas()
            scaledActivityChartDatasets.forEach(scaledActivityChartDataset => {
                datasets.push(scaledActivityChartDataset)
            });
            makeChart(chartLabels, datasets);
        }
    });
};


const interfaceEventListner = (dateRange, mainActivitiesPlusColor,scaledActivityChartDatasets) => {
    document.getElementById("interface").addEventListener("click", () => {
        console.log("interface cliked");
        let checkedBoxes = [];
        mainActivitiesPlusColor.forEach((mainActivityPlusColor) => {
            if (document.getElementById(mainActivityPlusColor[0]).checked) {
                checkedBoxes.push(mainActivityPlusColor[0]);
            }
        });
        if (checkedBoxes.length > 0) {
            const totalTimesForMultipleMainActivities =
                getTotalTimesForMultipleMainActivities(checkedBoxes, dateRange);

            const mainActsTotalsColors = addColorToMainActivitiesTotals(
                totalTimesForMultipleMainActivities,
                mainActivitiesPlusColor
            );
            const { chartLabels, datasets } = convertMainActTotalsToGraphInput(
                mainActsTotalsColors,
                dateRange
            );
            console.log('main datasets')
            console.log(datasets)
            console.log('scaled datasets')
            console.log(scaledActivityChartDatasets)
            scaledActivityChartDatasets.forEach(scaledActivityChartDataset => {
                datasets.push(scaledActivityChartDataset)
            });
            console.log('combined datasets')
            console.log(datasets)
            //add the scaled activities dataset here
            // scaledActivityChartDatasets
            // clearCanvas()
            makeChart(chartLabels, datasets);
        }
    });
};

const combined = () => {
    const dateRange = getDateRange(); // get the date ranges
    const mainActivitiesPlusColor = getAllMainActivitiesWithAssociatedColor();
    const uniqueDailyScaledActivities = getUniqueScaledActivities();
// const dateRange = getDateRange();
const dailyAverageScaledActvitiesScores =calcDailyAverageScaledActivitiesScore(dateRange, uniqueDailyScaledActivities);
const scaledActivityChartDatasets = convertDailyScaledActivitiesScoresToChartDatasets(dailyAverageScaledActvitiesScores)


    createMainActivityInterface(mainActivitiesPlusColor);
    interfaceEventListner(dateRange, mainActivitiesPlusColor,scaledActivityChartDatasets);
    checkAllButton(dateRange, mainActivitiesPlusColor,scaledActivityChartDatasets);
};



// const uniqueDailyScaledActivities = getUniqueScaledActivities();
// const dateRange = getDateRange();
// const dailyAverageScaledActvitiesScores =calcDailyAverageScaledActivitiesScore(dateRange, uniqueDailyScaledActivities);
// const scaledActivityChartDatasets = convertDailyScaledActivitiesScoresToChartDatasets(dailyAverageScaledActvitiesScores)
// console.log(scaledActivityChartDatasets)
combined()
///////////////////////////////test stuff

const testChart = () => {
    var ctx = document.getElementById("testchart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: [
                "<  1",
                "1 - 2",
                "3 - 4",
                "5 - 9",
                "10 - 14",
                "15 - 19",
                "20 - 24",
                "25 - 29",
                "> - 29",
            ],
            datasets: [
                {
                    label: "Employee",
                    backgroundColor: "#caf270",
                    data: [12, 59, 5, 56, 58, 12, 59, 87, 45],
                    stack: "Stack 0",
                },
                {
                    label: "Engineer",
                    backgroundColor: "#45c490",
                    data: [12, 59, 5, 56, 58, 12, 59, 85, 23],
                    stack: "Stack 0",
                },
                {
                    label: "Government",
                    backgroundColor: "#008d93",
                    data: [12, 59, 5, 56, 58, 12, 59, 65, 51],
                    stack: "Stack 1",
                    barThickness: 10,
                    barPercentage: 1.0,
                },
                {
                    label: "Political parties",
                    backgroundColor: "#2e5468",
                    data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
                    stack: "Stack 2",
                    barThickness: 10,

                    barPercentage: 1.0,
                },
            ],
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Chart.js Bar Chart - Stacked",
                },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                },
            },
        },
    });
};

// testChart();

console.log(dailyActivities);
