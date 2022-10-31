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
let [startDate, endDate] = getStartAndEndDate()
console.log(startDate, endDate)




document.querySelectorAll("input[name='activitiesQuestionsRadio']").forEach((input) => {
    input.addEventListener('change', () => {
        activitiesQuestionsState = input.value
        // console.log('states',weekMonthState,activitiesQuestionsState)
        // changePickers()

    });
});

document.querySelectorAll("input[name='weekMonthRadio']").forEach((input) => {
    input.addEventListener('change', () => {
        weekMonthState = input.value
        // console.log('states',weekMonthState,activitiesQuestionsState)
        changePickers()
    });
});


const changePickers = () => {
    console.log("weekMonthState ", weekMonthState)
    if (weekMonthState == "week") {
        const startDateIsoWeek = moment().year() + "-W" + startDate.isoWeek()
        const endDateIsoWeek = moment().year() + "-W" + endDate.isoWeek()

        // const test = moment("2022-01-12","YYYY-MM-DD").isoWeek().toString()
        document.getElementById("startWeek").setAttribute("min", startDateIsoWeek.padStart(2, '0'));
        document.getElementById("startWeek").setAttribute("max", endDateIsoWeek.padStart(2, '0'));
        document.getElementById("endWeek").setAttribute("min", startDateIsoWeek.padStart(2, '0'));
        document.getElementById("endWeek").setAttribute("max", endDateIsoWeek.padStart(2, '0'));
        document.getElementById("weekpicker").classList.remove("d-none");
        document.getElementById("monthpicker").classList.add("d-none");
    }
    if (weekMonthState == "month") {
        // console.log("startDateMonth",startDateMonth)

        const startDateMonth = moment().year() + "-" + startDate.format("MM")
        const endDateMonth = moment().year() + "-" + startDate.format("MM")
        document.getElementById("startMonth").setAttribute("min", startDateMonth);
        document.getElementById("startMonth").setAttribute("max", endDateMonth);
        document.getElementById("endMonth").setAttribute("min", startDateMonth);
        document.getElementById("endMonth").setAttribute("max", endDateMonth);
        document.getElementById("weekpicker").classList.add("d-none");
        document.getElementById("monthpicker").classList.remove("d-none");

    }
}

const makeGraph = () => {
    document.getElementById('makeGraph').addEventListener('click', () => {
        const startWeekValue = document.getElementById("startWeek").value
        const endWeekValue = document.getElementById("endWeek").value
        if (startWeekValue != "" && endWeekValue != "") {
            document.getElementById('startEndWeekEmpty').classList.add("d-none");

            console.log("make the graph")
            console.log("week start and end ", startWeekValue, endWeekValue)
        } else {
            document.getElementById('startEndWeekEmpty').classList.remove("d-none");
        }

        console.log("startWeekvalue is ", startWeekValue)
    })
}

makeGraph()

const filterDailyActivitiesForDate = (startDate, endDate) => {
    const filtered = dailyActivities.filter((log) => {
        if (moment(log.created_at) >= moment(startDate, "YYYY-MM-DD") && moment(log.created_at) <= moment(endDate, "YYYY-MM-DD")) {
            return log
        }

    })
    // console.log("nbon filted activities ", dailyActivities.length)
    // console.log("filted array length activities ",filtered.length)
    // console.log(filtered)
    return filtered
}

const getUniqueScaledAndMainActivities = (dailyActivities) => {
    let allMainActivities = []
    let allScaledActivities = []
    dailyActivities.forEach((dailyActivityLog) => {
        dailyActivityLog.main_activities.forEach((mainActivities) => {
            allMainActivities = allMainActivities.concat(mainActivities)
        });
        dailyActivityLog.scaled_activities.forEach((scaledActivities) => {
            allScaledActivities = allScaledActivities.concat(scaledActivities)
        });
    });

    const uniqueMainActivities = [...new Set(allMainActivities)]
    const uniqueScaledActivities = [...new Set(allScaledActivities)]
    return [uniqueMainActivities, uniqueScaledActivities]


}
//rekenin ghouden met jaar wisseling
const makeWeekActivitiesDataRange = (uniqueMainActivities, uniqueScaledActivities) => {
    const startWeekValue = document.getElementById("startWeek").value
    const endWeekValue = document.getElementById("endWeek").value
    const intStartWeek = parseInt(startWeekValue.split("W")[1])
    const intEndWeek = parseInt(endWeekValue.split("W")[1])
    const startYear = startWeekValue.split("W")[0].substring(0, 4)
    const endYear = endWeekValue.split("W")[0].substring(0, 4)

    const weekDiff = intEndWeek - intStartWeek

    let dateRange = []
    for (let i = 0; i < weekDiff; i++) {

        const newWeek = {
            weekNr: intStartWeek + i,
            mondayDate: moment(startYear).add(intStartWeek + i, 'weeks').weekday(1),
            sundayDate: moment(startYear).add(intStartWeek + i, 'weeks').weekday(7),
            activityLogs: null,
            questionLogs: null,
            mainActivityTotal: null,
            scaledActivityAverages: null,
            uniqueMainActivities: uniqueMainActivities,
            uniqueScaledActivities: uniqueScaledActivities,
            datasets: null,
            labels: null,
            filteredDatasets: null,


        }
        dateRange.push(newWeek)
    }
    // console.log(dateRange)
    return dateRange
}

const addActivityLogsToWeekDateRange = (dateRange, filtedActivitiesLogs) => {
    dateRange.forEach(week => {
        let logs = []
        for (let i = 0; i < 7; i++) {
            const date = week.mondayDate.clone().add(i, 'days')
            const thisLog = null
            filtedActivitiesLogs.forEach(log => {
                if (log.date_today == date.format("YYYY-MM-DD")) {
                    thisLog = log
                }
            });

            logs.push({
                date: date,
                log: thisLog,

            })

        }
        week.activityLogs.push(logs)
        

    });
}

const calcWeekMainActivityData = (dateRange)=>{
    dateRange.forEach(week => {

        week.uniqueMainActivities.forEach(mainActivity => {
            // array = [ma, di,wo etc]
            // week.activityLogs.forEach(dayActivities => {
            
            // });
        });

       
      
    });

}


const test = () => {
    console.log(dailyActivities[0])
    const filtedDailyActivitiesLogs = filterDailyActivitiesForDate("2022-10-05", "2022-10-18")
    const [uniqueMainActivities, uniqueScaledActivities] = getUniqueScaledAndMainActivities(filtedDailyActivitiesLogs)
    // console.log(uniqueMainActivities)
    // console.log(uniqueScaledActivities)
    const weekActivtyDateRange = makeWeekActivitiesDataRange(uniqueMainActivities, uniqueScaledActivities)
    const dateRangeWithLogs = addActivityLogsToWeekDateRange(weekActivtyDateRange, filtedDailyActivitiesLogs)
    calcWeekMainActivityData(dateRangeWithLogs)
}



test()

// console.log("date sizzle")
// let datetest = moment("2022").add(56, 'weeks').weekday(1)
// console.log(datetest)





