page layout

input: activities/daily rapports selection
input: week/ month selection

Depending on week or month selection the correct week or month picker is 
added both for a start/end week/month.

week activities, month activities
week questions, month questions

filterDailyActivitiesForStartEndDate():
1: filter the dailyActivities logs for start and end date this should improve improve performace down the line
2: return filterDailyActivities

getUniqueMainActivities():
1: get all unique main activities
2: return uniqueMainActivities

getUniqueScaledActivities():
1: get all unique scaled activities
2: return uniqueScaledActivities

makeWeekDateRange():
1: get start and end week
2: for each week create the following

{
    weeknr:
    mondayDate:
    sundayDate:
    weekActivityLogs:[{date:.. log:..}] orderd for date
    weekQuestionLogs: [{date:.. log:..}] orderd for date
    weekDailyMainActivityTotals: [{mainActivityName:...,dailyTotals:[mondayTotal,tuesdayTotal, etc]}]
    uniqueMainActivities: [programmeren, lezen etc]
    uniqueScaledActivities: [pijn level, gespannen etc]
    WeekDailyScaledActivityAverages:[{scaledActivityName:...,dailyAve:[mondayAve,tuesdayAve, etc]}]
    weekDataSet: graph datasets
    weeklabels: graph day labels
    filterdDatasets: filtered weekDataset for user input

}

3:return array of all the week

addActivityLogsToWeekDateRange()
1: foreach weeknr in makeWeekDateRange() foreach date in weekActivityLogs
2: find the the corresponding log in filterDailyActivitiesForStartEndDate() and this.
return the array:

calcWeekMainActivityLogsData()
1: foreach weeknr in addActivityLogsToWeekDateRange() foreach date in weekActivityLogs foreach uniqueMainActivity in uniqueMainActivities:
2: calc the total minutes spend on that mainActivity.
2: create weekDailyMainActivityTotals for each week.
return the updated array

calcWeekScaledActivityLogsData():
1: foreach weeknr in addActivityLogsToWeekDateRange() foreach date in weekActivityLogs foreach uniqueScaledActivity in uniqueScaledActivities:
2: calc the average score for the uniqueScaledActivity
return the updatd array

generateWeekActivityGrapDatasets():
1: foreach weeknr in addActivityLogsToWeekDateRange() foreach weekDailyMainActivityTotals generate the following
   {
                    label: mainActivity from uniqueMainActivities,
                    backgroundColor:colorArray,
                    data: weekDailyMainActivityTotals [12, 59, 5, 56, 58, 12, 59, 85, 23],
                    stack: "Stack 0",
                },

2: foreach weeknr in addActivityLogsToWeekDateRange() foreach WeekDailyScaledActivityAverages generate the following
   {
                    label: scaledActivity from uniqueScaledActivities,
                    backgroundColor:colorArray[i],
                    data: WeekDailyScaledActivityAverages[12, 59, 5, 56, 58, 12, 59, 85, 23],
                    stack: "Stack 1", // each uniqueScaledActivity should get its own stack
                },

add mainActivity and scaledActivity stuff to weekDataSet
return 

createWeekLabels():
    add labels to the makeWeekDateRange: Each label is a day of the week plus date

    return makeWeekDateRange


filterDatasets():
    based on mainActivity scaledActivty check box state filter the datasets:
    return 

createWeekActivityGraphs():
    foreach week in makeWeekDateRange generate a graph for
        filterdDatasets title is weeknumber


///////////////button stuff
1:make in index div for main activity and scale activity buttons
2: only scaled or mainly activity buttons
3: 

addScaledCheckboxes():
    for all scaled activiies add checboxes to scaledCheck div

addMainCheckboxes():
    for all main activities add checkboxes to mainCheck div

addEventListners(): input is the div find all div check boxes
    add eventlistners to to scaledCheck and mainCheck div on change
    get all the checkboxes that are checked and get the value
    return these


we have a group of checkboxes in an unique div
we want to disable on a button press all the checked checboxes in this div/group

add an event listner to the div that listens to changes in the div when a change
has been noticed retrieve all checked boxes and generate the graph

when the button is pressed thus and eventlistner disables all the checed boxes


/// ik heb een list van main en scaled activities
/// foreach main acitivity create an checkbox and add these to the mainActivityCheckBoxesDiv -> the id of the checkbox is the mainActiviy name
//after adding the checkboxes add an button that disables all mainActivity chekcb



