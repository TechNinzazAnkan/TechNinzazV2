$(document).on('ready', function(evt, data){
	
	var url = window.location.pathname;
    console.log(url);
	var filename = url.substring(url.lastIndexOf('/')+1);
	console.log(filename);

	/*	Code for Admin Page to check Corporate FeedBack Starts Here	*/

	if(filename == 'feedbackListing.html'){

        $.ajax({
            url     : "http://www.techninzaz.com/backend_code.php",
            type    : "POST",
            data    : {
                        'func': 'corporateFeedbackListing'
                    },
            success : function (data){
                console.log(data);
                var completeData = JSON.parse(data);

                var table = $('.corporateFeedbackListing').DataTable({
                    "paging": true,
                    "ordering": true,
                    "info": false,
                    "data": completeData.data,
                    "iDisplayLength": 10,
                    "columns": [{
                        "data": "studentName"
                    }, {
                        "data": "courseObtained"
                    }, {
                        "data": "facultyName"
                    }, {
                        "data": "overallRating"
                    }, {
                        "data": null,
                        "render":function(data,type,complete){
                            return "<a href='/filledCorporateFeedback.html?id="+complete.id+"'><button class = 'btn btn-primary rqButton' id ='rq_id_"+complete.studentName+"'> View </button></a>"
                        }
                    }],
                    columnDefs: [{ type: 'natural', targets: 0 }]
                });
            },
            error : function(e){
                console.log(e.responseText);
            }
        });
				
	} else if(filename == 'corporateFeedBackLogin.html'){
        var adminLogin =$('#loginButton');
        adminLogin.click(function(event){
            event.preventDefault();
            var userName = $("#userName").val();
            var userPwd = $("#userPwd").val();

            if(userName == "admin" && userPwd == "password"){
                window.location.href = "feedbackListing.html";
            }
            else {
                alert("Use Correct Credentials");
            }
            
        });
    } else if(filename == 'filledCorporateFeedback.html'){
        var source = window.location.href;
        var splittedSource = source.replace(/\s{2,}/g, '').split('?id=');

        var userId = splittedSource[1];
        console.log(userId);
        
        $.ajax({
            url     : "http://www.techninzaz.com/backend_code.php",
            type    : "POST",
            data    : {
                        "userId" : userId,
                        "func" : 'filledCorporateFeedback'
                    },
            success : function (data){
                console.log(data);
                var res = JSON.parse(data);
                console.log(res);
                $("#cfbf_name").val(res.name);
                $("#cfbf_email").val(res.email);
                $("#cfbf_phoneNo").val(res.phone);
                $("#cfbf_textareaOne").val(res.courseProblemFaced);
                $('#cfbf_textareaTwo').val(res.futureSuggestion);
                $('#cfbf_textareaThree').val(res.otherComments);
                $("input[name=courseRatingOne][value='"+res.overallRatingCourse+"']").prop('checked', true);
                $("input[name=courseRatingTwo][value='"+res.topicSequenceCourse+"']").prop('checked', true);
                $("input[name=courseRatingThree][value='"+res.courseMaterial+"']").prop('checked', true);
                $("input[name=courseRatingFour][value='"+res.courseObjectiveExpectation+"']").prop('checked', true);
                $("input[name=facultyRatingOne][value='"+res.facultyCommunication+"']").prop('checked', true);
                $("input[name=facultyRatingTwo][value='"+res.facultyPreperation+"']").prop('checked', true);
                $("input[name=facultyRatingThree][value='"+res.facultyQueryResponse+"']").prop('checked', true);
                $("input[name=facultyRatingFour][value='"+res.facultyTrainingMethod+"']").prop('checked', true);
                $("#cfbf_courseName").val(res.courseObtained).prop("selected",true);
                $("#cfbf_staffName").val(res.facultyName).prop("selected",true);
            },
            error : function(e){
                console.log(e.responseText);
            }
        });
    }

});