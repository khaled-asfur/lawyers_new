/* global $, document  */
 
$(document).ready(function(){
    $("body").niceScroll({
             cursorcolor:"#31b0d5",
             cursorwidth:"7px"
    });
        $('.view-button').click(function(){
        var doc=document.getElementById('show-details');
        $(doc).css('display','block');
    });
    $('#submit-type-of-financial').click(function(){
      var value=$('input[name=groupTypeFinancial]:checked').val() ;
        switch(value){
            case "money":
              var doc1=document.getElementsByClassName("prem-add-details");
                $(doc1).css('display','none');
              var doc1=document.getElementsByClassName("checks-add-details");
                $(doc1).css('display','none');
                break;
            case "checks":
              var doc1=document.getElementsByClassName("prem-add-details");
                $(doc1).css('display','none');
              
                var doc=document.getElementsByClassName("checks-add-details");
                $(doc).css('display','block');
                break;
            case "prem":
                var doc1=document.getElementsByClassName("checks-add-details");
                $(doc1).css('display','none');  
                var doc=document.getElementsByClassName("prem-add-details");
                $(doc).css('display','block');
                break;
        }
    });
    $('.add-checks-div').click(function(){
        $(".detail-checks:first").clone().insertAfter(".detail-checks:last");
    });
    $('.add-prem-div').click(function(){
        $(".prem-details:first").clone().insertAfter(".prem-details:last");
    });
    $('#btn-addNewFinancial').click(function(){
       var doc=document.getElementsByClassName('addNew-section') ;
        $(doc).css('display','block');
    });
});