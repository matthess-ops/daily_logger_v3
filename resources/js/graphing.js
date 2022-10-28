import moment from "moment";



console.log("dit werkt")

const getStartAndEndDate = () => {
    const dates = dailyActivities.map((dailyActivity) =>
        moment(dailyActivity.date_today, "YYYY-MM-DD")
    );
    const startDate = moment.min(dates);
    const endDate = moment.max(dates);

    return [startDate, endDate];
};


let weekMonthState = "week"
let activitiesQuestionsState = "activities"
let [startDate,endDate] = getStartAndEndDate()
console.log(startDate,endDate)




document.querySelectorAll("input[name='activitiesQuestionsRadio']").forEach((input) => {
    input.addEventListener('change', ()=>{
        activitiesQuestionsState = input.value
        // console.log('states',weekMonthState,activitiesQuestionsState)
        // changePickers()

    });
});

document.querySelectorAll("input[name='weekMonthRadio']").forEach((input) => {
    input.addEventListener('change', ()=>{
        weekMonthState = input.value
        // console.log('states',weekMonthState,activitiesQuestionsState)
        changePickers()
    });
});


const changePickers = ()=>{
    console.log("weekMonthState ",weekMonthState)
    if(weekMonthState == "week"){
        const startDateIsoWeek = moment().year()+"-W"+startDate.isoWeek()
        const endDateIsoWeek = moment().year()+"-W"+endDate.isoWeek()

        // const test = moment("2022-01-12","YYYY-MM-DD").isoWeek().toString()
        document.getElementById("startWeek").setAttribute("min", startDateIsoWeek.padStart(2, '0'));
        document.getElementById("startWeek").setAttribute("max", endDateIsoWeek.padStart(2, '0'));
        document.getElementById("endWeek").setAttribute("min", startDateIsoWeek.padStart(2, '0'));
        document.getElementById("endWeek").setAttribute("max", endDateIsoWeek.padStart(2, '0'));
        document.getElementById("weekpicker").classList.remove("d-none");
        document.getElementById("monthpicker").classList.add("d-none");
    }
    if(weekMonthState=="month"){
        // console.log("startDateMonth",startDateMonth)

        const startDateMonth = moment().year()+"-"+startDate.format("MM")
        const endDateMonth = moment().year()+"-"+startDate.format("MM")
        document.getElementById("startMonth").setAttribute("min", startDateMonth);
        document.getElementById("startMonth").setAttribute("max", endDateMonth);
        document.getElementById("endMonth").setAttribute("min",startDateMonth );
        document.getElementById("endMonth").setAttribute("max", endDateMonth);
        document.getElementById("weekpicker").classList.add("d-none");
        document.getElementById("monthpicker").classList.remove("d-none");

    }
}







