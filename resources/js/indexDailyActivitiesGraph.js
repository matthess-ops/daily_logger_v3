console.log("indexDailyActivitiesGraph called");
// console.log(dailyActivities)

import moment from "moment";
import Chart from "chart.js/auto";

const getStartAndEndDate = () => {
    const dates = dailyActivities.map((dailyActivity) =>
        moment(dailyActivity.date_today, "YYYY-MM-DD")
    );
    console.log(dates);
    // let moments = dates.map(d => d),
    const startDate = moment.min(dates);
    const endDate = moment.max(dates);

    return [startDate, endDate];
};

const addStartAndEndDateToDatePickers = () => {
    const [startDate, endDate] = getStartAndEndDate();
    document.getElementById("startDate").value = startDate.format("YYYY-MM-DD");
    document.getElementById("endDate").value = endDate.format("YYYY-MM-DD");
};

const hasDatePickersForValidInput = () => {
    const startDatePickerValue = document.getElementById("startDate").value;
    const endDatePickerValue = document.getElementById("endDate").value;
    console.log(
        "startdate ",
        JSON.stringify(startDatePickerValue),
        typeof startDatePickerValue
    );
    // if(startDatePickerValue)
    if (startDatePickerValue == "" || endDatePickerValue == "") {
        // startEndDateEmpty
        document.getElementById("startEndDateEmpty").classList.remove("d-none");
        return false;
    } else {
        document.getElementById("startEndDateEmpty").classList.add("d-none");

        const isEndDateAfterStartDate =
            moment(startDatePickerValue).isAfter(endDatePickerValue);
        if (isEndDateAfterStartDate) {
            document
                .getElementById("startEndDateError")
                .classList.remove("d-none");
            return false;
        } else {
            document
                .getElementById("startEndDateError")
                .classList.add("d-none");
            return true;
        }
        return true;
    }
};

addStartAndEndDateToDatePickers();

//1: retrieve client  dailyActivities en dailyQuestion on each page load
//2: create div with userInput add radio button group for week/month, radio button group for dailyActivity or dailyreports and startdate/endate datepicker
//datepicker startDate
//datepicker endDate
//radiobutton week
//radiobutton month
//radiobutton dailyActivity
//radiobutton dailyQuestions

//3: limit datepicker startDate and endDate to the start and enddate of the retrieved logs
//4: listen if startDate and endDate have input, if input generate/show the radiobuttons
//5: continuesly listen to userInput for changes if changes check all inputs for state changes if changes generate graphs

// ok we hebben week en maand graphs, week bevat voor elke dag 1 activity or question log
// maand bevat voor elke graph bar 7 activity or questions logs
//

//vraag is:
// voor maand data de start datum pakken maar allen volle weken pakken, elke week start op maande.
// dus als een datum geselecteerd is op een dinsdag alleen het spul van de week daarop pakken.
//

// pseudo code
// getDates(week or month)
// usecase, activity data, week,

// makeWeeklyDateRange()
// for start and end date get the week numbers, for each week get the day data
// array should look like
// [{weeknr,monday{date,activityLog,dialyQuestionareLog},tuesday{date,activityLog,dialyQuestionareLog}....}]

const makeWeeklyDateRange = () => {
    //take and date however if the date is not a monday, the weeknr should be of the next week
    const getDateWeekNr = (date, mode) => {
        if (date.format("dddd") == "Monday") {
            return date.isoWeek();
        } else {
            return date.isoWeek() + 1;
        }
    };

    const startDate = moment(document.getElementById("startDate").value);
    const endDate = moment(document.getElementById("endDate").value);

    const startWeek = getDateWeekNr(startDate);
    const endWeek = getDateWeekNr(endDate);
    const diffInWeeks = endWeek - startWeek;
    const startWeekMondayDate = moment(moment().year())
        .add(startWeek, "weeks")
        .startOf("isoweek");
    // const endWeekMondayDate =  moment(moment().year()).add(endWeek, 'weeks').startOf('isoweek')
    // console.log('makeWeeklyDateRange start ',startWeekMondayDate)
    // set up
    // # year and month are variables

    return;
};

//makeWeekActivityDateRange()
//for start and end date get week numbers
// for each day in the week, monday till sunday generate and element
//return array as
//[{weeknr:2,weekDates:[{date:10-01-22},{date:10-01-23}]}]

//addActivityLogsToWeekDateRange(makeWeekActivityDateRange())
// foreach week foreach date in makeWeekActivityDateRange()
// add the correct dailyActivities data
// return array as
//[{weeknr:2,weekDates:[{date:10-01-22,activityLog:...},{date:10-01-23,activityLog:...}]}]

//calcActivityLogsTotalsAverages(addActivityLogsToWeekDateRange())
// foreach week foreach activityLog in addActivityLogsToWeekDateRange()
// calc sum for the mainActivities and averages for scaledActivities

// SUBFUNCTIONS:
// getAllUniqueMainActivitiesFromDateRange(addActivityLogsToWeekDateRange()):
// getAllUniqueScaledActivitiesFromDateRange(addActivityLogsToWeekDateRange()):

//  return uniqueMainActivities array  sorted[programmeren,gamen,huishouden etc]
//  return uniqueScaledActivities sorted[stress, piekeren, pijn etc]

//foreach mainActivity in getAllUniqueMainActivitiesFromDateRange()
//calc total minutes for mainActivity add to mainActivities array
///////DO the same for scaledActivity but then the average score // take into account that both scaled and main activities have different unique color arrays

//return array
//[uniqueMainActivities:[{name:programmen,color:red}],uniqueScaledActivities:[{name:stress,color:blue}],weeks:{weeknr:2,weekDates:[{date:10-01-22,activityLog:...,scaledActivities[{scaledActivityName:pijn level, aveScore:int(7)}],mainActivities[{mainActivityName:programmeren,totalMins:300},{mainActivityName:games,totalMins:90}]},{date:10-01-23,activityLog:...}]}]

//ConvertActivityTotalAveragesToGraphData(calcActivityLogsTotalsAverages())
//foreach week in weeks
//foreach unique main Activity in uniqueMainActivities get the corresponding totalMins. add these to datasets array
// {
//     label: mainActivity,
//     backgroundColor: mainActivity color,
//     data: [week1totalmins,week2totalmins, etc],
//     stack: "stack 0",

//     yAxisID: 'y',
// }
//foreach unique scaled activity uniqueScaledActivities get the corresponding ave scores
//TOMORROW FIND OUT HOW TO PUT STACKED BAR AND NON STACKED BAR IN SAME GRAPH

const makeGraph = () => {
    document.getElementById("makeGraph").addEventListener("click", () => {
        const dateInputValid = hasDatePickersForValidInput();
        if (dateInputValid) {
            const graphTypeMode = document.querySelector(
                'input[name="activitiesQuestionsRadio"]:checked'
            ).value;
            const graphTimeMode = document.querySelector(
                'input[name="weekMonthRadio"]:checked'
            ).value;
            if (graphTimeMode == "week" && graphTypeMode == "activities") {
                console.log("graphTimeMode", graphTimeMode, graphTypeMode);
                const weekDateRange = makeWeeklyDateRange();
            }
        }
    });
};

makeGraph();

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

                {
                    label: "Political parties",
                    backgroundColor: "#2f5468",
                    data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
                    stack: "Stack 3",
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

testChart()

const testGetWeeks = () => {
    var start = moment("2022-11"), // Sept. 1st
        end = moment("2022-12"), // Nov. 2nd
        day = 1; // Sunday

    var result = [];
    var current = start.clone();

    while (current.day(7 + day).isBefore(end)) {
        result.push(current.clone());
    }

    console.log(result.map((m) => m.format("LLLL")));
};

testGetWeeks();
