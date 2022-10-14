// get daterange
// get all unique daily questions
// get for each daily question for each date in date range the value
// generate graph
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
    console.log("doet dit het ");
    const dates = dailyQuestions.map((dailyQuestion) =>
        moment(dailyQuestion.created_at)
    );
    const earliestDate = dates[0];
    const latestDate = dates[dates.length - 1];
    const diffInDays = latestDate.diff(earliestDate, "days");
    let dateRange = [];
    for (let day = 0; day < diffInDays; day++) {
        const newdate = earliestDate.add("days", 1);
        dateRange.push(newdate.clone());
    }
    return dateRange;
};

const getUniqueDailyQuestions = () => {

    let allQuestions = []
    // array.concat doesnt work
    dailyQuestions.forEach(dailyQuestion => {
        dailyQuestion.questions.forEach(question => {
            allQuestions.push(question)
        });
    });
    const uniqueQuestions = [...new Set(allQuestions)]
    return uniqueQuestions

};
//foreach question foreach date find the index of question in dailyquestion
// rewrite to make quicker// problem constantly looping through stuff
//better to pull the dailyquestion plus scores and date from the dailyQuestions and then search it, computationally less expensive
const makeDailyQuestionScoresDataForDateRange = (dates,questions,whichScores)=>{
    let data =[]
    questions.forEach(question => {
        let questionScores = []
        dates.forEach(date => {
            let scorefound =  false
            dailyQuestions.forEach(dailyQuestion => {
                if(date.format("YYYY-MM-DD") == moment(dailyQuestion.created_at).format("YYYY-MM-DD"))
                {
                    const questionIndex = dailyQuestion.questions.findIndex((dailyQuestion)=>dailyQuestion==question)
                    const score = dailyQuestion[whichScores][questionIndex]
                    if(score == 0){
                        questionScores.push(NaN)

                    }else{
                        questionScores.push(score)

                    }
                    scorefound =true
                }

            });
            if(scorefound == false){
                questionScores.push(NaN)

            }
        });
        data.push({
            question:question,
            scores:questionScores
        })
    });
    return data
}

const convertDatesQuestionScoresToChartDataset = (datesQuestionScores,labelPrefix)=>{
    let datasets = []
    datesQuestionScores.forEach( (dateQuestionScore,index) => {
        datasets.push(
            {
                label: labelPrefix+"_"+dateQuestionScore.question,
                backgroundColor: colorScheme[index],
                data: dateQuestionScore.scores,
                borderColor:colorScheme[index],
            }
        )

    });
    return datasets


}
//combine the dataset get new colors
const combindClientMentorDatasets = (clientDataset,mentorDataset)=>{
    const combinedArray = [...clientDataset, ...mentorDataset];
    return combinedArray

}

const makeGraph = (chartDatasets, chartLabels)=>{

    let chartStatus = Chart.getChart("chart"); // <canvas> id
    if (chartStatus != undefined) {
        chartStatus.destroy();
        //(or)
        // chartStatus.clear();
    }

    var ctx = document.getElementById("chart").getContext("2d");

    var myChart = new Chart(ctx, {
        type: "line",
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



            },
        },
    });

    myChart.update();
}

const createQuestionsInterface = (questions,whichInterface, idPrefix) => {
    const questionsInterface = document.getElementById(whichInterface);
    questions.forEach((question) => {
        const newLabel = document.createElement("label");
        newLabel.setAttribute("for", "checkbox");
        newLabel.innerHTML = question;

        const newCheckbox = document.createElement("input");
        newCheckbox.setAttribute("type", "checkbox");
        newCheckbox.setAttribute("id", idPrefix+"_"+question);

        const br = document.createElement("br");

        questionsInterface.appendChild(newLabel);
        questionsInterface.appendChild(newCheckbox);
        questionsInterface.appendChild(br);
    });
};

const questionInterfaceListner = ()=>{

    const dates = getDateRange();
    const questions =getUniqueDailyQuestions();
    const clientDatesQuestionScores = makeDailyQuestionScoresDataForDateRange(dates,questions,'scores');
    console.log('client scores')
    console.log(clientDatesQuestionScores)
    const mentorDatesQuestionScores = makeDailyQuestionScoresDataForDateRange(dates,questions,'mentor_scores');
    console.log('mentor scores')
    console.log(mentorDatesQuestionScores)
    const clientChartDatasets = convertDatesQuestionScoresToChartDataset(clientDatesQuestionScores,'client');
    const mentorChartDatasets = convertDatesQuestionScoresToChartDataset(mentorDatesQuestionScores,'mentor');
    console.log('clientChartDatasets')
    console.log(clientChartDatasets)
    console.log('mentorChartDatasets')
    console.log(mentorChartDatasets)
    const labels = dates.map((date)=>date.format('YYYY-MM-DD'))
    createQuestionsInterface(questions,'clientInterface','client')
    createQuestionsInterface(questions,'mentorInterface','mentor')
    const combinedClientMentorDatasets =combindClientMentorDatasets(clientChartDatasets,mentorChartDatasets)
    makeGraph(combinedClientMentorDatasets,labels)

    document.getElementById("interface").addEventListener("click", () => {
        const currentScrollPos = document.documentElement.scrollTop
        let checkedQuestions = [];
        questions.forEach((question) => {
            if (document.getElementById('client_'+question).checked) {
                checkedQuestions.push('client_'+question);
            }
            if (document.getElementById('mentor_'+question).checked) {
                checkedQuestions.push('mentor_'+question);
            }
        });
        const filterdDataSets = []
        checkedQuestions.forEach(checkedQuestion => {
            combinedClientMentorDatasets.forEach(charData => {
                if(checkedQuestion == charData.label){
                    filterdDataSets.push(charData)
                }
            });
        });
        console.log('filterdata sets');
        console.log(filterdDataSets)
        makeGraph(filterdDataSets,labels)
        window.scrollTo(0, currentScrollPos)
    })
}


questionInterfaceListner()

