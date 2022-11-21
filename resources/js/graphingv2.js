import moment from "moment";
import Chart from "chart.js/auto";
import testexport from "./testexport.js"
// import generateDailyActivitiesGraphs from "./dayActivitiesGraph"
// import generateWeeklyActivitiesGraphs from "./weekActivitiesGraph"

//user selects week or monthly data
// user selects if its wants to generate activity or questions data
// user select start and end week / user selects start and end month

// check for week or monthly state change
// check if user want to generate activity or questions data
// calculate the begin and end date or either activity or questions data
// change the date pickers to week and month and change begin and end date
console.log("graphingv2.js");
console.log("daily activities");
console.log(dailyActivities);
console.log("daily questions");
console.log(dailyQuestions);

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

const getActivitiesStartEndDate = () => {
    const dates = dailyActivities.map((dailyActivity) =>
        moment(dailyActivity.date_today, "YYYY-MM-DD")
    );
    const startDate = moment.min(dates);
    const endDate = moment.max(dates);

    return [startDate, endDate];
};

const getQuestionsStartEndDate = () => {
    const dates = dailyQuestions.map((dailyQuestion) =>
        moment(dailyQuestion.date_today, "YYYY-MM-DD")
    );
    const startDate = moment.min(dates);
    const endDate = moment.max(dates);

    return [startDate, endDate];
};
console.log(getQuestionsStartEndDate());

let weekMonthState = "week";
let activitiesQuestionsState = "activities";
let [activitiesStartDate, activitiesEndDate] = getActivitiesStartEndDate();
let [questionsStartDate, questionsEndDate] = getQuestionsStartEndDate();
// console.log("activities dates ",activitiesStartDate, activitiesEndDate)
// console.log("questions dates ",questionsStartDate, questionsEndDate)
let datepicker = document.getElementById("datePicker");
const makeGraphButton = document.getElementById("makeGraphButton");
// let weekRadio = document.getElementById('weekRadio')
// let monthRadio = document.getElementById('monthRadio')
// let questionsRadio = document.getElementById('questionsRadio')
// let activitiesRadio =  document.getElementById('activitiesRadio')

const clearDatePicker = () => {
    datepicker.innerHTML = "";
};

const createNewDatePicker = (type, id, min, max) => {
    let newStartDatePicker = document.createElement("input");
    newStartDatePicker.setAttribute("type", type);
    newStartDatePicker.setAttribute("id", id);
    newStartDatePicker.setAttribute("min", min);
    newStartDatePicker.setAttribute("max", max);

    newStartDatePicker.classList.add("form-control");
    datepicker.appendChild(newStartDatePicker);
};

const updateDatePicker = () => {
    if (weekMonthState == "week") {
        if (activitiesQuestionsState == "activities") {
            console.log("should be week activities pickers");
            clearDatePicker();
            const weekMin =
                "2022-W" +
                activitiesStartDate.isoWeek().toString().padStart(2, "0");
            const weekMax =
                "2022-W" +
                activitiesEndDate.isoWeek().toString().padStart(2, "0");
            createNewDatePicker("week", "startDate", weekMin, weekMax);
            createNewDatePicker("week", "endDate", weekMin, weekMax);
        } else if (activitiesQuestionsState == "questions") {
            console.log("should be week questions pickers");

            clearDatePicker();
            const weekMin =
                "2022-W" +
                questionsStartDate.isoWeek().toString().padStart(2, "0");
            const weekMax =
                "2022-W" +
                questionsEndDate.isoWeek().toString().padStart(2, "0");
            createNewDatePicker("week", "startDate", weekMin, weekMax);
            createNewDatePicker("week", "endDate", weekMin, weekMax);
        }
    } else if (weekMonthState == "month") {
        if (activitiesQuestionsState == "activities") {
            console.log("should be month activities pickers");

            clearDatePicker();
            const monthMin =
                activitiesStartDate.year() +
                "-" +
                activitiesStartDate.format("MM");
            const monthMax =
                activitiesEndDate.year() + "-" + activitiesEndDate.format("MM");
            createNewDatePicker("month", "startDate", monthMin, monthMax);
            createNewDatePicker("month", "endDate", monthMin, monthMax);
        } else if (activitiesQuestionsState == "questions") {
            console.log("should be month questions pickers");

            clearDatePicker();
            const monthMin =
                questionsStartDate.year() +
                "-" +
                questionsStartDate.format("MM");
            const monthMax =
                questionsEndDate.year() + "-" + questionsEndDate.format("MM");
            createNewDatePicker("month", "startDate", monthMin, monthMax);

            createNewDatePicker("month", "endDate", monthMin, monthMax);
        }
    }
};

updateDatePicker();

document
    .querySelectorAll("input[name='activitiesQuestionsRadio']")
    .forEach((input) => {
        input.addEventListener("change", () => {
            activitiesQuestionsState = input.value;
            updateDatePicker();
        });
    });

document.querySelectorAll("input[name='weekMonthRadio']").forEach((input) => {
    input.addEventListener("change", () => {
        weekMonthState = input.value;
        updateDatePicker();
    });
});

const makeDatePickerErrors = (errorString) => {
    let datePickerErrorDiv = document.getElementById("datePickerErrors");

    datePickerErrorDiv.innerHTML = "";
    let newElement = document.createElement("div");
    newElement.classList.add("alert");
    newElement.classList.add("alert-danger");
    newElement.innerText = errorString;

    datePickerErrorDiv.appendChild(newElement);
};

// makeDatePickerErrors("test")
/////////////////////////// graph stuff//////////////////////

const checkStartAndEndDateErrors = () => {
    const startDate = document.getElementById("startDate");
    console.log("statdate is ", startDate);
    const endDate = document.getElementById("endDate");
    console.log("startdate ", startDate, endDate);

    if (startDate.value == "" && endDate.value == "") {
        console.log("error no start and end date");
        makeDatePickerErrors("Voer een start en eind week/maand in.");
        return false;
    }

    if (startDate.value == "" && endDate.value != "") {
        console.log("error no start date");
        makeDatePickerErrors("Voor een start week/maand in.");
        return false;
    }
    if (endDate.value == "" && startDate.value != "") {
        console.log("error no end date");
        makeDatePickerErrors("Voor een eind week/maand in.");
        return false;
    }

    if (
        weekMonthState == "week" &&
        endDate.value != "" &&
        startDate.value != ""
    ) {
        const startDateMoment = moment(startDate.value, "YYYY-[W]WW");
        const endDateMoment = moment(endDate.value, "YYYY-[W]WW");
        if (startDateMoment.isBefore(endDateMoment)) {
            console.log("stuff is good");
            let datePickerErrorDiv =
                document.getElementById("datePickerErrors");
            datePickerErrorDiv.innerHTML = "";
            return true;
        } else {
            console.log("week start date is before end date");
            makeDatePickerErrors("Start week moet na eind week zijn");
            return false;
        }
    }

    if (
        weekMonthState == "month" &&
        endDate.value != "" &&
        startDate.value != ""
    ) {
        const startDateMoment = moment(startDate.value, "YYYY-MM");
        const endDateMoment = moment(endDate.value, "YYYY-MM");
        if (startDateMoment.isBefore(endDateMoment)) {
            console.log("stuff is good");
            let datePickerErrorDiv =
                document.getElementById("datePickerErrors");

            datePickerErrorDiv.innerHTML = "";
            return true;
        } else {
            console.log("month start date is before end date");
            makeDatePickerErrors("Start maand moet na eind maand zijn.");
            return false;
        }
    }
};

const main = () => {
    makeGraphButton.addEventListener("click", () => {
        console.log("click registerd");
        const noErrors = checkStartAndEndDateErrors();
        document.getElementById('chartDiv').innerHTML =""

        if(noErrors){
            const startDate = document.getElementById("startDate").value;
            const endDate = document.getElementById("endDate").value;
            if (weekMonthState == "week") {
                if (activitiesQuestionsState == "activities") {
               
                
                    // generateWeeklyActivitiesGraphs(startDate,endDate)

                    console.log("createweek activities graph");
                } else if (activitiesQuestionsState == "questions") {

                    
                    // generateWeeklyActivitiesGraphs(startDate,endDate)
                    console.log("create week questions graph");
                }
            } else if (weekMonthState == "month") {
                if (activitiesQuestionsState == "activities") {
                    console.log("create month activities graph");
                } else if (activitiesQuestionsState == "questions") {
                    console.log("create month questions graph");
                }
            }
        }else{
            console.log("ERRRORS DETETECETD")
        }

    });
};

 main();



