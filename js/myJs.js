myArray = [0];

function highlightCell(e) {

    e.classList.toggle("sum-item");

    var resultDiv = document.getElementById("result");
     if (e.classList == "sum-item") {
        myArray.push(+e.innerHTML);

     }
      var sum = myArray.reduce(
        (accumulator, currentValue) => accumulator + currentValue
      );
             resultDiv.innerHTML =  sum;

    resultDiv.addEventListener("click", function () {
        myArray = []
        resultDiv.innerHTML =  0;
    })
}