console.log("check hour boxes function called");


const checkHourButtons = ()=>{
    const hourButtons = document.getElementsByName('hourButton')
    hourButtons.forEach(hourButton => {
        hourButton.addEventListener('click',()=>{
            const firstCheckBoxToCheck = hourButton.value * 4 - 1;
            const secondCheckBoxToCheck = hourButton.value * 4 - 2;
            const thirdCheckBoxToCheck = hourButton.value * 4 - 3;
            const fourthCheckBoxToCheck = hourButton.value * 4 - 4;
            const checkBoxesToCheck = [
                firstCheckBoxToCheck,
                secondCheckBoxToCheck,
                thirdCheckBoxToCheck,
                fourthCheckBoxToCheck,
            ];

            checkBoxesToCheck.forEach((checkBoxToCheck) => {
                document.getElementById(
                    "boxOn_" + checkBoxToCheck
                ).checked = true;
            });
        })
    });
}
checkHourButtons()
