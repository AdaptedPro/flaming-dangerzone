// JavaScript Document 
var availableCountries = ["Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bonaire","Bosnia &amp; Herzegovina","Botswana","Brazil","British Indian Ocean Ter","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Canary Islands","Cape Verde","Cayman Islands","Central African Republic","Chad","Channel Islands","Chile","China","Christmas Island","Cocos Island","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Ter","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Great Britain","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guyana","Haiti","Hawaii","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea North","Korea South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malaysia","Malawi","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Midway Islands","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Nambia","Nauru","Nepal","Netherland Antilles","Netherlands (Holland, Europe)","Nevis","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Norway","Oman","Pakistan","Palau Island","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn Island","Poland","Portugal","Puerto Rico","Qatar","Republic of Montenegro","Republic of Serbia","Reunion","Romania","Russia","Rwanda","St Barthelemy","St Eustatius","St Helena","St Kitts-Nevis","St Lucia","St Maarten","St Pierre &amp; Miquelon","St Vincent &amp; Grenadines","Saipan","Samoa","Samoa American","San Marino","Sao Tome &amp; Principe","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Tahiti","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos Is","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Vietnam","Virgin Islands (Brit)","Virgin Islands (USA)","Wake Island","Wallis &amp; Futana Is","Yemen","Zaire","Zambia","Zimbabwe"];
var availableSubjects = ["Architecture & Design", "Astronomy", "Biomedical Sciences", "Business & Management", "Chemistry", "Computer Science", "Earth Sciences & Geography", "Economics", "Education & Language", "Energy", "Engineering", "Environmental Sciences", "Food Science & Nutrition", "Law", "Life Sciences", "Materials", "Mathematics", "Medicine", "Philosophy", "Physics", "Psychology", "Public Health", "Social Sciencess", "Statistics"];
var availableYears;
var no_search;

function get_more() {    
    $("#loading").append("<img src='images/loader.gif' alt='Loading.' />");
    $.ajax({
        type: "GET",
        url: "/springer/ajax/2"
        }).done(function(m) {
            if (m['success']==true) {
                var msg = m['data'];
                $("#content ul").append(msg);
                $('#content ul').listview('refresh');
                document.getElementById("loading").innerHTML = "";                
            }
        });
}

function goto_top() {
    $.mobile.silentScroll(0);
}

function search_state(_x) {
    if (_x == 0) {
        //Remove advanced form
         $("#adv-form").remove();
         $('#k-word').show().trigger( 'updatelayout' );
    } else { 
        $('#k-word').hide().trigger( 'updatelayout' );
    
        //Create advanced form        
        $.ajax({
            type: "GET",
            url: "/springer/ajax/1",
            dataType: 'json',
            }).done(function( m ) {
                if (m['success']==true) {
                    var msg = m['data'];
                } else {
                    var msg = '';
                }
                
            $('#adv-switch').after(msg);
            $('#h-content').trigger('create');
            
            $("#country").autocomplete({
                target: $('#suggestions-1'),
                source: availableCountries,
                callback: function(e) {
                    var $a = $(e.currentTarget);
                    $('#country').val($a.text());
                    $("#country").autocomplete('clear');
                },
                link: 'results.php?n=',
                minLength: 1
            });
            
            $("#subject").autocomplete({
                target: $('#suggestions-2'),
                source: availableSubjects,
                callback: function(e) {
                    var $a = $(e.currentTarget);
                    $('#subject').val($a.text());
                    $("#subject").autocomplete('clear');
                },
                link: 'results.php?n=',
                minLength: 1
            });  
      
          $("#year").autocomplete({
                target: $('#suggestions-3'),
                source: availableYears,
                callback: function(e) {
                    var $a = $(e.currentTarget);
                    $('#year').val($a.text());
                    $("#year").autocomplete('clear');
                },
                link: 'results.php?n=',
                minLength: 1
            });

        });
    }
}

function init() {
    var arr = new Array();
    var d   = new Date();
    var t   = d.getFullYear() - 1969;    
    for (i = 0; i < t; i++) {
        y = d.getFullYear() - i;
        arr.push(y);  
    }
    availableYears = arr;
}