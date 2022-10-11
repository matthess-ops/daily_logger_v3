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

// let myChart = null
// var myChart = new Chart(ctx, data);
// myChart.config.data = new_data;
// myChart.update();

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
                },
            },
        },
    });

    myChart.update()
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


const checkAllButton = (dateRange,mainActivitiesPlusColor)=>{

    document.getElementById('all').addEventListener('click',()=>{
        console.log('clicked button')

        mainActivitiesPlusColor.forEach(mainActivityPlusColor => {
            document.getElementById(mainActivityPlusColor[0]).checked = true
        });
        let checkedBoxes = [];
        mainActivitiesPlusColor.forEach((mainActivityPlusColor) => {
            if (document.getElementById(mainActivityPlusColor[0]).checked) {
                checkedBoxes.push(mainActivityPlusColor[0]);
            }
        });
        if (checkedBoxes.length >0) {

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
            makeChart(chartLabels, datasets);
        }
    })

}

const combined = ()=>{
    const dateRange = getDateRange(); // get the date ranges
    const mainActivitiesPlusColor = getAllMainActivitiesWithAssociatedColor();
    createMainActivityInterface(mainActivitiesPlusColor);
    interfaceEventListner(dateRange,mainActivitiesPlusColor)
    checkAllButton(dateRange,mainActivitiesPlusColor)
}


const interfaceEventListner = (dateRange,mainActivitiesPlusColor) => {




    document.getElementById("interface").addEventListener("click", () => {
        console.log('interface cliked');
        let checkedBoxes = [];
        mainActivitiesPlusColor.forEach((mainActivityPlusColor) => {
            if (document.getElementById(mainActivityPlusColor[0]).checked) {
                checkedBoxes.push(mainActivityPlusColor[0]);
            }
        });
        if (checkedBoxes.length >0) {

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
            makeChart(chartLabels, datasets);
        }
    });
};


combined()
// interfaceEventListner();
// checkAllButton()
