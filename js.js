"use strict";
//Time variables for time intervals selection
var now = new Date();
var today = new Date(new Date().setHours(0, 0, 0));
var yesterday = new Date(new Date().setDate(new Date().getDate() - 1));
var thisWeek = new Date(new Date().setDate(new Date().getDate() - 7));
var lastWeek = new Date(new Date().setDate(new Date().getDate() - 14));
yesterday = new Date(yesterday.setHours(0, 0, 0));
thisWeek = new Date(thisWeek.setHours(23, 59, 59));
lastWeek = new Date(lastWeek.setHours(23, 59, 59));
//Time variables to set the selection 
var timeRange1;
var timeRange2;
var t1;
var t2;
var firstDateOfAction;
//top number of page
var gesamtTeilnehmerTop;
var gerubbelterFelderTop;
var teilnehmerHeuteTop;
//var for tables 
var dataFiltered = [];
//var activityTable = [];//table Content
var ggrbtfldrCounts = {};//time redundancy 
var ggrbtfldrCounts2 = {};//time redundancy 
//charts
var barChart;
var doughnutChart;
//DB Array
var databases = [];
var activityComparison = [];

$(document).ready(function () {
  getDatabaseNames();
  actionComparison(databases);
  getTableFirstTime();
  addAction();
});
//get db names
function getDatabaseNames() {
  databases = [];
  $.ajax({
    type: 'GET',
    url: 'getDbNames.php',
    success: function (data) {
      var d = JSON.parse(data);
      for (let i = 0; i < d.length; i++) {

        let str = d[i]['Database (%_db5634)'];
        let str1 = str.substring(0, str.length - 7);//trim special dashboard db signs
        let str0 = str1.slice(0, 13);
        let str2 = str1.substring(14, str.length) // trim timestamp.
        databases.push([str0, str2]);
      }
    },
    async: false
  });
  console.log(databases);
}
// it compares all the actions and take values for the last diagramm
function actionComparison(_dataB) {
  var firstDateOfActionCopmparison;
  var dataFilteredComparison = [];
  activityComparison = [];
  ggrbtfldrCounts2 = {};
  ggrbtfldrCounts2 = [];

  for (let i = 0; i < _dataB.length; i++) {
    $.ajax({
      type: 'GET',
      url: 'connObject.php',
      data: {
        db: _dataB[i][0] + '_' + _dataB[i][1] + '_db5634'
      },
      success: function (d) {
        if (d !== null) {
          var dataFromDB;
          dataFromDB = JSON.parse(d);
          dataFilteredComparison = setDataObject(dataFromDB);
          firstDateOfActionCopmparison = getFirstDateOfAction(dataFromDB);
          ggrbtfldrCounts2 = getGesamtGerubbelterFelder(dataFromDB);
          if (dataFilteredComparison !== undefined) {
            activityComparison.push(setTableContent(dataFilteredComparison, firstDateOfActionCopmparison, now));
          }
        }
        else {
          i++;
        }
      }, async: false
    });
  }
  vergleichChartData(activityComparison);
}
//2 action comparison charts
function vergleichChartData(arr) {
  var years = [];
  var dayMonth = [];
  var feld = [];
  var user = [];

  for (let i = 0; i < arr.length; i++) {
    if (arr !== undefined) {
      const year = new Date(arr[i][0]['datum']);
      for (let j = 0; j < arr[i].length; j++) {
        const el2 = arr[i][j]['datum'];
        const el3 = arr[i][j]['userProTag'];
        const el4 = arr[i][j]['gesamtFelder'];
        dayMonth.push(new Date(el2).getDate());
        user.push(el3);
        feld.push(el4);
      }

      years.push([year.getFullYear(), user.reverse(), feld.reverse(), dayMonth.reverse()]);
      dayMonth = [];
      feld = [];
      user = [];
      years.reverse();
    } else {
      i++;
    }
  }

  var l = [];
  var a = [];
  var z = [];
  var colors = ['red', 'green', 'blue', 'yellow', 'orange', 'purple', 'pink', 'gray'];
  for (let index = 0; index < years.length; index++) {
    a[index] = {
      label: years[index][0],//////
      fill: false,
      lineTension: 0.5,
      data: years[index][1],//////
      backgroundColor: '#fff',
      borderColor: colors[index],//////
      borderCapStyle: 'round',
      borderDashOffset: 0.5,
      borderjoinStyle: 'round'
    }
    z[index] = {
      label: years[index][0],//////
      fill: false,
      lineTension: 0.5,
      data: years[index][2],//////
      backgroundColor: '#fff',
      borderColor: colors[index],//////
      borderCapStyle: 'round',
      borderDashOffset: 0.5,
      borderjoinStyle: 'round'
    }
    l = years[0][3];
  };


  //Aktion Vergleichen Chart 1
  var line = document.getElementById('myChartNutzer')
  var lineChart1 = new Chart(line, {
    type: 'line',
    data: {
      labels: l,
      datasets: a,
    },
    options: {
      scales: {
        xAxes: [{
          gridLines: {
            color: "rgba(0, 0, 0, 0)",
          }
        }],
        yAxes: [{
          gridLines: {
            color: "rgba(0, 0, 0, 0)",
          }
        }]
      }
    }
  });
  var line = document.getElementById('myChartFelder')
  var lineChart2 = new Chart(line, {
    type: 'line',
    data: {
      labels: l,
      datasets: z,
    },
    options: {
      scales: {
        xAxes: [{
          gridLines: {
            color: "rgba(0, 0, 0, 0)",
          }
        }],
        yAxes: [{
          gridLines: {
            color: "rgba(0, 0, 0, 0)",
          }
        }]
      }
    }


  });
}
//get the first table from db first time
function getTableFirstTime() {
  laden();
  var _db = databases.reverse();
  var a = [];
  _db.forEach(el => {
    $.ajax({
      type: 'GET',
      url: 'connObject.php',
      data: {
        db: el[0] + '_' + el[1] + '_db5634'//first db in db array
      },
      success: function (data) {
        a.push(JSON.parse(data));
      }, async: false
    })
  })
  for (let i = 0; i < a.length; i++) {
    const element = a[i];
    if (element !== null) {
      callAllFunctions(element);
      break;
    }
  }
}
//charts destroy
function destroyCharts() {
  herkunftTableDestroy();//clear the former data of chart.
  barChart.destroy();
  doughnutChart.destroy();
}
//call all func
function callAllFunctions(dt) {
  dataFiltered = setDataObject(dt);
  ggrbtfldrCounts = [];
  ggrbtfldrCounts = getGesamtGerubbelterFelder(dt);
  getGenders(dt);
  firstDateOfAction = getFirstDateOfAction(dt);
  getNumbers('ganzeAktion');
  innerHtml();
  getAges(dataFiltered);
  getStates(dataFiltered);
}
//loader
function laden() {
  $("#gerubbelterFelder").text('laden...');
  $("#teilnehmerHeute").text('laden...');
  $("#gesamtTeilnehmer").text('laden...');
}
//convert date object to human readable format
function dateConversion(date) {
  if (date === '-') {
    return '--.--.----';
  } else {
    var d = new Date(date);
    var dd = d.getDate();
    var mm = d.getMonth() + 1;
    var yy = d.getFullYear();
    if (dd < 10) { dd = '0' + dd }
    if (mm < 10) { mm = '0' + mm }
    return dd + '-' + mm + '-' + yy;
  }
}
function getFirstDateOfAction(dt) {
  if (dt !== null) {
    return new Date(new Date(dt[0]["created_at"]));
  }
}
//filter row data coming from db
function setDataObject(dt) {

  var dataFilter = [];
  var dmtIndex = 0;
  if (dt !== null) {

    dataFilter.push([dt[0]["created_at"],
    dt[0]["firstname"],
    dt[0]["lastname"],
    dt[0]["city"],
    dt[0]["zip"],
    dt[0]["birthday"],
    [dt[0]["feldersDatum"]]]);

    for (let i = 1; i < dt.length - 1; i++) {

      if (dt[i]["created_at"] !== dt[i - 1]["created_at"]) {
        dmtIndex++;
        dataFilter.push([dt[i]["created_at"],
        dt[i]["firstname"],
        dt[i]["lastname"],
        dt[i]["city"],
        dt[i]["zip"],
        dt[i]["birthday"],
        [dt[i]["feldersDatum"]]
        ]);
      } else {
        dataFilter[dmtIndex][6].push(dt[i]["feldersDatum"]);
      }
    }
    //console.log(dataFilter);
    return dataFilter;

  }
}
//gesamtgerubblter Felder
function getGesamtGerubbelterFelder(dt) {
  if (dt !== null) {
    var grflist = [];
    grflist.push([dt[0]["feldersDatum"]]);

    for (let i = 1; i < dt.length; i++) {
      grflist.push([dt[i]["feldersDatum"]]);
    }
    //convert dd-mm-yyyy
    var ggrbtfldr = [];
    grflist.forEach(element => {
      var date = new Date(element);
      var dateForm = dateConversion(date);
      ggrbtfldr.push([dateForm]);
    });

    //redundancy
    //ggrbtfldrCounts = {};
    grflist = ggrbtfldr;
    grflist.forEach(function (x) {
      ggrbtfldrCounts[x] = (ggrbtfldrCounts[x] || 0) + 1;
    });
    //console.log(ggrbtfldrCounts);
    return ggrbtfldrCounts;
  }
}
//create gender Diagramm
function getGenders(dt) {
  if (dt !== null) {
    var gender = [];
    var f = dt[dt.length - 1]["female"];
    var m = dt[dt.length - 1]["male"];
    //percentage
    gender.push(Math.round((m * 100) / (f + m)));
    gender.push(Math.round((f * 100) / (f + m)));
    //Doughnut Chart - gender
    var context = document.getElementById("donutChart");
    doughnutChart = new Chart(context, {
      type: 'doughnut',
      data: {
        labels: ['Männlich', 'Weblich'],
        datasets: [{
          label: [
            'rgba(9, 108, 48, 0.5)',
            'rgba(137, 138, 139, 0.2)'
          ],
          data: gender,
          backgroundColor: [
            'rgb(9, 108, 48)',
            'rgb(137, 138, 139)'
          ]
        }]
      },
      options: {
        responsive: false
      }
    });
  }
}
//set table content according to time selection
function setTableContent(arr, _t1, _t2) {
  if (arr !== undefined) {
    var activity = [];
    var _datum;
    var userProTag = 0;
    var neueAdressdatenProTag = 0;
    var anzahlGerubbelterFelder = 0;
    var gesamtGerubbleterFelder = 0;
    var gesamtTeilnehmer = 0;
    var act = [];//table rows
    let index = 0;
    var dateUser = arr[index][0];
    do {
      _datum = dateUser;
      userProTag++;
      gesamtTeilnehmer++;

      if (arr[index][4] !== null || arr[index][5] !== null) {
        //city and zip are not null
        neueAdressdatenProTag++;
      }

      for (const [key, value] of Object.entries(ggrbtfldrCounts)) {
        if (key === dateConversion(_datum)) {
          anzahlGerubbelterFelder = value;
        }
      }

      index++;
      dateUser = arr[index][0];
      if (dateConversion(_datum) !== dateConversion(dateUser)) {
        gesamtGerubbleterFelder += anzahlGerubbelterFelder;
        //if a new date comes, make a new line
        var data = {
          'datum': _datum,
          'userProTag': userProTag,
          'adressdaten': neueAdressdatenProTag,
          'anzahlFelder': anzahlGerubbelterFelder,
          'gesamtFelder': gesamtGerubbleterFelder,
          'gesamtTeilnehmer': gesamtTeilnehmer
        };

        act.push(data);
        //reset first 3 values
        userProTag = 0;
        anzahlGerubbelterFelder = 0;
        neueAdressdatenProTag = 0;
        teilnehmerHeuteTop = 0;
        gesamtTeilnehmerTop = gesamtTeilnehmer;
        gerubbelterFelderTop = gesamtGerubbleterFelder;
      }

    } while (index < arr.length - 1)

    var act2 = [];
    act.forEach(element => {

      var a = new Date(element.datum).setHours(0, 0, 1);

      if (a >= today.getTime() && a < now.getTime()) {
        teilnehmerHeuteTop = element.userProTag;
      }

      if (new Date(a).getTime() > _t1.getTime() && new Date(a).getTime() < _t2.getTime()) {
        //element.datum = dateConversion(element.datum);
        act2.push(element);
      }
    });

    if (act2.length === 0) {
      var data2 = {
        datum: '-',
        userProTag: 0,
        adressdaten: 0,
        anzahlFelder: 0,
        gesamtFelder: gesamtGerubbleterFelder,
        gesamtTeilnehmer: gesamtTeilnehmer
      }
      act2.push(data2);
    }
    activity = act2;
    activity.reverse();
    return activity;
  }
}
//get time selection
function getNumbers(id) {
  switch (id) {
    case 'heute':
      t1 = today;
      t2 = now;
      break;
    case 'gestern':
      t1 = yesterday;
      t2 = today;
      break;
    case 'letzteWoche':
      t1 = lastWeek;
      t2 = thisWeek;
      break;
    case 'aktuelleWoche':
      t1 = thisWeek;
      t2 = now;
      break;
    case 'ganzeAktion':
      t1 = firstDateOfAction;
      t2 = now;
      break;
    case 'datumAuswählen':
      t1 = timeRange1;
      t2 = timeRange2;
      break;
  }

  if (id !== 'datumAuswählen') {
    $('#sp').text('Datum Auswählen');
  }

  loadTableData(setTableContent(dataFiltered, t1, t2));
  activeFirstButton(id);
}
//get states from zip
function getStates(arr) {
  if (arr !== undefined) {
    var stateArray = [];
    var items = [];
    $.getJSON("plz.json", function (data) {
      $.each(data, function (key, val) {
        items.push([val["zipcode"], val["state"]]);
      });
      //make an array with states
      for (let i = 0; i < arr.length; i++) {
        for (let a = 0; a < items.length; a++) {

          if (arr[i][4] === items[a][0]) {
            stateArray[i] = items[a][1];
          }
        }
      }
      //get how many time states repeat 
      var counts = {};
      stateArray.forEach(function (x) { counts[x] = (counts[x] || 0) + 1; });
      //make it sortable arry
      var sortable = [];
      for (var c in counts) {
        sortable.push([c, counts[c]]);
      }
      //sort descending
      sortable.sort(function (a, b) {
        return b[1] - a[1];
      });
      //table vars
      var herkunft = [];
      var user = [];

      for (let i = 0; i < sortable.length; i++) {
        const element = sortable[i];
        herkunft.push(element[0]);
        user.push(element[1]);
      }
      //control group of nonexist states
      var bundesland = [
        "Bayern",
        "Berlin",
        "Brandenburg",
        "Bremen",
        "Baden-Württemberg",
        "Hamburg",
        "Hessen",
        "Mecklenburg-Vorpommern",
        "Niedersachsen",
        "Nordrhein-Westfalen",
        "Rheinland-Pfalz",
        "Saarland",
        "Sachsen",
        "Sachsen-Anhalt",
        "Schleswig-Holstein",
        "Thüringen",
      ];
      //check which states are not in the game, and add them with 0 value
      var a = [];
      for (var i = 0; i < bundesland.length; i++) {
        a[bundesland[i]] = true;
      }
      for (var i = 0; i < herkunft.length; i++) {
        if (a[herkunft[i]]) {
          delete a[herkunft[i]];
        } else {
          a[herkunft[i]] = true;
        }
      }
      for (var k in a) {
        herkunft.push(k);
        user.push(0);
      }

      loadHerkunftTable(herkunft, user);

      herkunft = [];
      user = [];
    });
  }
}
//Fill herkunft table
function loadHerkunftTable(herkunft, items) {

  const table1 = document.getElementById("herkunftBody1");
  const table2 = document.getElementById("herkunftBody2");

  for (let i = 0; i < herkunft.length; i++) {
    if (i < 8) {
      let row = table1.insertRow();
      let ort = row.insertCell(0);
      let userWoche = row.insertCell(1);

      ort.innerHTML = herkunft[i];
      userWoche.innerHTML = items[i];

    } else {
      let row = table2.insertRow();
      let ort = row.insertCell(0);
      let userWoche = row.insertCell(1);

      ort.innerHTML = herkunft[i];
      userWoche.innerHTML = items[i];
    }
  }
}
//destroy state table
function herkunftTableDestroy() {
  $("#herkunftBody1").empty();
  $("#herkunftBody2").empty();
}
//age calculation
function getAges(arr) {
  if (arr !== undefined) {
    var _18 = new Date().setFullYear(new Date().getFullYear() - 18);
    var _25 = new Date().setFullYear(new Date().getFullYear() - 25);
    var _35 = new Date().setFullYear(new Date().getFullYear() - 35);
    var _45 = new Date().setFullYear(new Date().getFullYear() - 45);
    var _55 = new Date().setFullYear(new Date().getFullYear() - 55);
    var _65 = new Date().setFullYear(new Date().getFullYear() - 65);

    var b = 0; var c = 0; var d = 0; var e = 0; var f = 0; var g = 0;

    for (let i = 0; i < arr.length; i++) {

      var a = new Date(arr[i][5]).getTime();

      if (a <= _65) {
        b++;
      } if (a > _65 && a <= _55) {
        c++;
      } if (a > _55 && a <= _45) {
        d++;
      } if (a > _45 && a <= _35) {
        e++;
      } if (a > _35 && a <= _25) {
        f++;
      } if (a > _25 && a <= _18) {
        g++;
      }
    };
    var ages = [];
    var _data = [];
    var dataFirst = [];
    var total = b + c + d + e + f + g;
    dataFirst = [g, f, e, d, c, b];
    for (let i = 0; i < dataFirst.length; i++) {
      _data.push(Math.round((dataFirst[i] / total) * 100));
    }
    ages = _data;

    //Bar Chart - age
    var ctx = document.getElementById("barChart").getContext("2d");
    var data = {
      labels: ["18 - 24", "25 - 34", "35 - 44", "45 - 54", " 55 - 64", "65 +"],
      datasets: [
        {
          label: "%",
          backgroundColor: "rgb(9, 108, 48)",
          data: ages
        }
      ]
    };
    barChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: {
        responsive: false,
        title: {
          display: false,
          text: 'Verteilung nach Alter'
        },
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 20,
            bottom: 0
          }
        },
        legend: false,
        scales: {
          xAxes: [{
            gridLines: {
              display: false,
              drawBorder: false,
              drawTicks: true
            },
            ticks: {
              fontStyle: 'bold',
              fontSize: 18,
              fontColor: "#333333",
              beginAtZero: true
            }
          }],
          yAxes: [{
            gridLines: {
              display: false,
              drawBorder: false,
              drawTicks: false,
              tickMarkLength: 15,
              borderDashOffset: 15
            },
            ticks: {
              display: false,
              fontStyle: 'bold',
              fontSize: 16,
              beginAtZero: true
            }
          }]
        }
      }
    });
  }
}
// Add Active Class to Current Element
function changeIt() {

  var header = document.getElementById("dateElements");
  var btns = header.getElementsByClassName("timeButons");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function () {
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
    });
  }
}
function activeFirstButton(_id) {
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  document.getElementById(_id).className += " active";
}
//add action
function addAction() {
  $('.popup-opener').click(function () {
    $('#popup-overlay').css('opacity', '0');
    $('#popup-overlay').css('display', 'table');
    $('#popup-overlay').animate({ opacity: '1' }, 500);
  });

  $('#popup-closer').click(function () {
    $('#popup-overlay').css('display', 'none');
  });

  var nameValue = document.getElementById("newAct").value;


  console.log(nameValue);

  if (nameValue !== '') {
    document.getElementById("warten").innerHTML = 'Bitte warten..'
    addActionToDataBase(nameValue);
  } else {
    $('#popup-overlay').css('display', 'none');
  }




}
//add Action To DataBase
function addActionToDataBase(name) {
  var dateTime = new Date().getTime();

  $.ajax({
    type: 'POST',
    url: 'createObject.php',
    data: {
      //db: dt +'_'+ name + '_db5634'
      db: dateTime + '_' + name + '_db5634'
    },
    success: function (data) {
      // var a = JSON.parse(data)
      // console.log(a);
      console.log(data);
    },
    async: false
  });

  location.reload();



}
// Dropdown Menu
function myFunction() {
  var menu = document.getElementById("myDropdown");
  $('#myDropdown').children("p").remove();//remove all previously created p's

  for (let i = 0; i < databases.length; i++) {
    console.log(databases[i]);
    const element = databases[i][1];
    const _dt = databases[i][0];

    var p = document.createElement('p');
    p.className = "button";
    p.id = element;
    p.innerHTML = element;
    p.addEventListener('click', function () {
      $.ajax({
        type: 'GET',
        url: 'connObject.php', data: {
          db: _dt + '_' + element + '_db5634'
        },
        success: function (data) {
          var dataFromDB = [];
          dataFromDB = JSON.parse(data);
          destroyCharts();
          callAllFunctions(dataFromDB);
        }
      });
    });
    menu.appendChild(p);
  }
  menu.classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
// Fill Aktivity table
function loadTableData(obj) {
  if (obj !== undefined) {
    $("#testBody").empty();
    const table = document.getElementById("testBody");
    obj.forEach(item => {
      let row = table.insertRow();
      let datum = row.insertCell(0);
      let userProTag = row.insertCell(1);
      let adressdaten = row.insertCell(2);
      let anzahlFelder = row.insertCell(3);
      let gesamtFelder = row.insertCell(4);
      let gesamtTeilnehmer = row.insertCell(5);
      datum.innerHTML = dateConversion(item.datum);
      userProTag.innerHTML = item.userProTag;
      adressdaten.innerHTML = item.adressdaten;
      anzahlFelder.innerHTML = item.anzahlFelder;
      gesamtFelder.innerHTML = item.gesamtFelder;
      gesamtTeilnehmer.innerHTML = item.gesamtTeilnehmer;
    });
  }
}
//datepicker 
$('#datumAuswählen').dateRangePicker({
  inline: true,
  format: 'DD-MM-YYYY',
  container: '#ccc',
  alwaysOpen: false,
  singleMonth: true,
  showTopbar: false,
  setValue: function (s) {
  }
})
  .bind('datepicker-change', (e, data) => {
    $('#sp').text(`${data.date1.toLocaleDateString()} - ${data.date2.toLocaleDateString()}`);
    timeRange1 = new Date(data.date1);
    timeRange2 = new Date(data.date2);
    //console.log(timeRange1, timeRange2);
    getNumbers('datumAuswählen');
  });
//fill top 3 number of the page
function innerHtml() {
  $("#gesamtTeilnehmer").text(gesamtTeilnehmerTop);
  $("#gerubbelterFelder").text(gerubbelterFelderTop);
  $("#teilnehmerHeute").text(teilnehmerHeuteTop);
}
