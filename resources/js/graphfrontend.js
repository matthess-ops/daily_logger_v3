console.log("graphfrontend");

import moment from "moment";
import generateDailyActivitiesGraphs from "./dayActivitiesGraph"
import generateWeeklyActivitiesGraphs from "./weekActivitiesGraph"
import generateDailyQuestionsGraphs from "./dayQuestionsGraph"
import generateWeeklyQuestionsGraphs from "./weekQuestionsGraph"
import testremarks from "./testremarks"


// find in dailyActivities logs the first earliest startdate and latest endDate
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
// find in dailyQuestions logs the first earliest startdate and latest endDate

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


//globals
let dailyWeeklyState = "day";
let activitiesQuestionsState = "activities";
let [activitiesStartDate, activitiesEndDate] = getActivitiesStartEndDate();
let [questionsStartDate, questionsEndDate] = getQuestionsStartEndDate();


const resetDatePickerValue =()=>{
    document.getElementById("startWeek").value =""
    document.getElementById("endWeek").value =""
}


//change the startWeek and endWeek datepickers min max to the corresponding dailyActiviteis or dailyQuestions min max dates
const changeDatePickersMinMax = (activitiesOrQuestions) => {
    const startWeekDatePicker = document.getElementById("startWeek");
    const endWeekDatePicker = document.getElementById("endWeek");
    if (activitiesOrQuestions == "activities") {
        startWeekDatePicker.min = activitiesStartDate;
        startWeekDatePicker.max = activitiesEndDate;
        endWeekDatePicker.min = activitiesStartDate;
        endWeekDatePicker.max = activitiesEndDate;
    } else if (activitiesOrQuestions == "questions") {
        startWeekDatePicker.min = questionsStartDate;
        startWeekDatePicker.max = questionsEndDate;
        endWeekDatePicker.min = questionsStartDate;
        endWeekDatePicker.max = questionsEndDate;
    }
};

//check for change in the activitiesQuestion radio buttons.
//if changend change use changeDatePickersMinMax("activities") or changeDatePickersMinMax("questions")
const checkForActivitiesQuestionsRadioChanges = () => {
    changeDatePickersMinMax("activities"); //initiate to activities

    document
        .querySelectorAll("input[name='activitiesQuestionsRadio']")
        .forEach((input) => {
            input.addEventListener("change", () => {
                activitiesQuestionsState = input.value;
                resetDatePickerValue()
                if (activitiesQuestionsState == "activities") {
                    changeDatePickersMinMax("activities");
                }
                if (activitiesQuestionsState == "questions") {
                    changeDatePickersMinMax("questions");
                }

            });
        });

    document.querySelectorAll("input[name='dayWeekRadio']").forEach((input) => {
        input.addEventListener("change", () => {
            resetDatePickerValue()
            dailyWeeklyState = input.value;
        });
    });
};
//make custom date picker erro
const makeDatePickerErrors = (errorString) => {
    let datePickerErrorDiv = document.getElementById("datePickerErrors");

    datePickerErrorDiv.innerHTML = "";
    let newElement = document.createElement("div");
    newElement.classList.add("alert");
    newElement.classList.add("alert-danger");
    newElement.innerText = errorString;

    datePickerErrorDiv.appendChild(newElement);
};


//check startWeek and endWeek datepicker for errors
const checkStartAndEndDateErrors = () => {
    const startWeek = document.getElementById("startWeek");
    const endWeek = document.getElementById("endWeek");
    //endweek and startweek are both not filled
    if (startWeek.value == "" && endWeek.value == "") {
        makeDatePickerErrors("Voer een start en eind week/maand in.");
        return false;
    }
    //only endweek is filled
    if (startWeek.value == "" && endWeek.value != "") {
        makeDatePickerErrors("Voor een start week/maand in.");
        return false;
    }
    //only startweek is filled
    if (endWeek.value == "" && startWeek.value != "") {
        makeDatePickerErrors("Voor een eind week/maand in.");
        return false;
    }
    // both startWeek and endWeek are filled
    if (endWeek.value != "" && startWeek.value != "") {
        const startDateMoment = moment(startWeek.value, "YYYY-[W]WW");
        const endDateMoment = moment(endWeek.value, "YYYY-[W]WW");
        //check if startDate is before endDate
        if (startDateMoment.isBefore(endDateMoment)) {
            let datePickerErrorDiv =
                document.getElementById("datePickerErrors");
            datePickerErrorDiv.innerHTML = "";
            return true;
        } else { //endDate if before startWeek
            makeDatePickerErrors("Start week moet na eind week zijn");
            return false;
        }
    }
};



const main = () => {
    checkForActivitiesQuestionsRadioChanges();

    makeGraphButton.addEventListener("click", () => {
        const noErrors = checkStartAndEndDateErrors();
        document.getElementById('chartDiv').innerHTML = ""
        console.log("no errors =", noErrors)
        if (noErrors) {
            const startWeek = document.getElementById("startWeek").value;
            const endWeek = document.getElementById("endWeek").value;
            if (activitiesQuestionsState == "activities") {
                if (dailyWeeklyState == "day") {

                    generateDailyActivitiesGraphs(startWeek, endWeek)
                    console.log("make daily activities graphs")
                }
                if (dailyWeeklyState == "week") {
                    generateWeeklyActivitiesGraphs(startWeek, endWeek)
                    console.log("make weekly activities graphs")
                }
            }
            if (activitiesQuestionsState == "questions") {
                if (dailyWeeklyState == "day") {
                    generateDailyQuestionsGraphs(startWeek, endWeek)
                    console.log("make daily questions graphs")
                }
                if (dailyWeeklyState == "week") {
                    generateWeeklyQuestionsGraphs(startWeek, endWeek)

                    console.log("make weekly questions graphs")
                }
            }
        }

    });
};

main();

// generateDailyQuestionsGraphs("2022-W35", "2022-W45")
// generateDailyActivitiesGraphs("2022-W45", "2022-W47")
generateWeeklyActivitiesGraphs("2022-W39", "2022-W47")


// testremarks()



