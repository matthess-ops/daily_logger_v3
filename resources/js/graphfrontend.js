console.log("graphfrontend");

import moment from "moment";
import generateDailyActivitiesGraphs from "./dayActivitiesGraph"
import generateWeeklyActivitiesGraphs from "./weekActivitiesGraph"
import generateDailyQuestionsGraphs from "./dayQuestionsGraph"



const getActivitiesStartEndDate = () => {
    const dates = dailyActivities.map((dailyActivity) =>
        moment(dailyActivity.date_today, "YYYY-MM-DD")
    );
    const startDate = moment.min(dates);
    const endDate = moment.max(dates);

    return [
        startDate.year() + "-W" + startDate.format("WW"),
        endDate.year() + "-W" + endDate.format("WW"),
    ];
};

const getQuestionsStartEndDate = () => {
    const dates = dailyQuestions.map((dailyQuestion) =>
        moment(dailyQuestion.date_today, "YYYY-MM-DD")
    );
    const startDate = moment.min(dates);
    const endDate = moment.max(dates);

    return [
        startDate.year() + "-W" + startDate.format("WW"),
        endDate.year() + "-W" + endDate.format("WW"),
    ];
};
console.log(getQuestionsStartEndDate());

let dailyWeeklyState = "day";
let activitiesQuestionsState = "activities";
let [activitiesStartDate, activitiesEndDate] = getActivitiesStartEndDate();
let [questionsStartDate, questionsEndDate] = getQuestionsStartEndDate();

const changeDatePickersMinMax = (activitiesOrQuestions) => {
    const startWeekDatePicker = document.getElementById("startWeek");
    const endWeekDatePicker = document.getElementById("endWeek");
    if (activitiesOrQuestions == "activities") {
        console.log("activities start dated ", activitiesStartDate);
        startWeekDatePicker.min = activitiesStartDate;
        startWeekDatePicker.max = activitiesEndDate;
        endWeekDatePicker.min = activitiesStartDate;
        endWeekDatePicker.max = activitiesEndDate;
    } else if (activitiesOrQuestions == "questions") {
        console.log("change datepicker to questions");
        startWeekDatePicker.min = questionsStartDate;
        startWeekDatePicker.max = questionsEndDate;
        endWeekDatePicker.min = questionsStartDate;
        endWeekDatePicker.max = questionsEndDate;
    }
};

const checkForRadioChanges = () => {
    changeDatePickersMinMax("activities");

    document
        .querySelectorAll("input[name='activitiesQuestionsRadio']")
        .forEach((input) => {
            input.addEventListener("change", () => {
                activitiesQuestionsState = input.value;
                if (activitiesQuestionsState == "activities") {
                    changeDatePickersMinMax("activities");
                }
                if (activitiesQuestionsState == "questions") {
                    changeDatePickersMinMax("questions");
                }
                console.log(
                    "dayweek and questionactivites state ",
                    dailyWeeklyState,
                    activitiesQuestionsState
                );
            });
        });

    document.querySelectorAll("input[name='dayWeekRadio']").forEach((input) => {
        input.addEventListener("change", () => {
            dailyWeeklyState = input.value;
        });
    });
};

const makeDatePickerErrors = (errorString) => {
    let datePickerErrorDiv = document.getElementById("datePickerErrors");

    datePickerErrorDiv.innerHTML = "";
    let newElement = document.createElement("div");
    newElement.classList.add("alert");
    newElement.classList.add("alert-danger");
    newElement.innerText = errorString;

    datePickerErrorDiv.appendChild(newElement);
};

const checkStartAndEndDateErrors = () => {
    const startWeek = document.getElementById("startWeek");
    const endWeek = document.getElementById("endWeek");

    if (startWeek.value == "" && endWeek.value == "") {
        makeDatePickerErrors("Voer een start en eind week/maand in.");
        return false;
    }

    if (startWeek.value == "" && endWeek.value != "") {
        makeDatePickerErrors("Voor een start week/maand in.");
        return false;
    }
    if (endWeek.value == "" && startWeek.value != "") {
        makeDatePickerErrors("Voor een eind week/maand in.");
        return false;
    }

    if (endWeek.value != "" && startWeek.value != "") {
        const startDateMoment = moment(startWeek.value, "YYYY-[W]WW");
        const endDateMoment = moment(endWeek.value, "YYYY-[W]WW");
        if (startDateMoment.isBefore(endDateMoment)) {
            let datePickerErrorDiv =
                document.getElementById("datePickerErrors");
            datePickerErrorDiv.innerHTML = "";
            return true;
        } else {
            makeDatePickerErrors("Start week moet na eind week zijn");
            return false;
        }
    }
};
const main = () => {
    checkForRadioChanges();

    makeGraphButton.addEventListener("click", () => {
        const noErrors = checkStartAndEndDateErrors();
        document.getElementById('chartDiv').innerHTML =""
        console.log("no errors =",noErrors)
        if(noErrors){
            const startWeek = document.getElementById("startWeek").value;
            const endWeek = document.getElementById("endWeek").value;
            if(activitiesQuestionsState =="activities"){
                if(dailyWeeklyState == "day"){

                    generateDailyActivitiesGraphs(startWeek,endWeek)
                    console.log("make daily activities graphs")
                }
                if(dailyWeeklyState=="week"){
                    generateWeeklyActivitiesGraphs(startWeek,endWeek)
                    console.log("make weekly activities graphs")
                }
            }
            if(activitiesQuestionsState=="questions"){
                if(dailyWeeklyState == "day"){
                    console.log("make daily questions graphs")
                }
                if(dailyWeeklyState=="week"){
                    console.log("make weekly questions graphs")
                }
            }
        }

    });
};

main();


const startDate = "2022-W40"
const endDate="2022-W47"

generateDailyQuestionsGraphs(startDate,endDate)
