/*jshint forin:true, noarg:true, noempty:true, bitwise:true, undef:true, unused:true, curly:true, browser:true, jquery:true, indent:4, maxerr:50 */
// window.addEventListener('load', function () {
	// new FastClick(document.body);
// }, false);

var editelement;

function extractSubjectFromURL(){
		
		var URL = location.pathname;
		if(URL.indexOf("subject") !== -1){
			var start_pos = URL.indexOf('subject', 0) + 8;
			if(URL[URL.length - 1]=='/'){
				var end_pos = URL.indexOf('/',start_pos);
			}else{
				var end_pos = URL.length;
			}
			var text_to_get = URL.substring(start_pos,end_pos);
			return text_to_get;
		}else{
			return false;
		}
	}

	function extractTopicFromURL(){
		
		var URL = location.pathname;
		if(URL.indexOf("topic") !== -1){
			var start_pos = URL.indexOf('topic', 0) + 6;
			if(URL[URL.length - 1]=='/'){
				var end_pos = URL.indexOf('/',start_pos);
			}else{
				var end_pos = URL.length;
			}
			var text_to_get = URL.substring(start_pos,end_pos);
			return text_to_get;
		}else{
			return false;
		}
	}

	function openSubject(id){
		$('dt[data-id="' + id + '"]').next().css('display','block');
		
	}


function popup(text, opacity, speed, cancel, functionWhenComplete, buttonText) {
	opacity = opacity || "0.5";
	opacity = 'rgba(68,68,68,' + opacity + ')';
	speed = speed || 500;
	buttonText = buttonText || "Ok";
	$('.overlay').css('background-color', opacity);
	$('.okbutton').html(buttonText);
	$('.popuptext').html(text);
	$('.overlay').fadeIn(speed, function () {
		$('.popup').fadeIn(speed);
	});
	if (typeof cancel !== 'undefined' && cancel == true) {
		$('.overlay tr').click(function () {
			popupHide();
		});
		$('.popup').click(function (e) {
			e.stopPropagation();
		});
		$('.popup').find('*').not('.okbutton').click(function (e) {
			e.stopPropagation();
		});
	}
	if (typeof functionWhenComplete == 'function') {

		functionWhenComplete();
	}
}

function popupHide(speed, functionWhenComplete) {
	speed = speed || 500;
	$('.overlay tr').unbind();

	$('.popup').unbind();
	$('.popup').find('*').not('.okbutton').unbind();
	$('.popup').fadeOut(speed, function () {
		$('.popup').css('width','12.5em');
		$('.newsubject').css('width','10em');
		$('.overlay').fadeOut(speed, function () {
			$('.okbutton').css('display', 'block');
			$('.popupSpinner').css('display', 'none');
			if (typeof flashAmber === 'undefined') {
				if (typeof functionWhenComplete === 'undefined') {

				} else {
					functionWhenComplete();
				}
			} else {
				clearTimeout(flashAmber);
				if (typeof functionWhenComplete === 'undefined') {

				} else {
					functionWhenComplete();
				}
			}
		});
	});
}

function refreshSubjects(functionWhenComplete, text) {
	$('.popupSpinner').css('display', 'block');
	$('.okbutton').css('display', 'none');
	text = text || "Refreshing subjects..."
	popup(text, 0.5, 500);
	getSubjects(function () {
		popupHide();
		functionWhenComplete();
	});
}

function getSubjects(functionWhenComplete) {
	getName();
	$.post("/subjectsajax.php",

	function (data) {
		$('.accordion').html(data);

		
		$('.slideout li').not('.topicadd').bind('click.showtopic', function(){
			getTopic($(this).data('id'), function(){
				popupHide();
			});
		});
		


		$('.topicadd').bind('click.topicadd', function () {

			popup("<input class='newsubject nname' data-id='" + $(this).data('id') + "' placeholder='Topic'></input>", 0.5, 500, true, function () {

				$('.okbutton').addClass('addtopicform');
				$('.addtopicform').bind('click.add', function () {
					$.post("/addtopic.php", {
						id: $('.nname').data('id'),
						topic: $('.nname').val()
					}, function (data) {

						if (data == "1") {
							popupHide(500, function () {
								var dataid = $('.nname').data('id');
								refreshSubjects(function () {



								});
								$('.addtopicform').unbind('click.add');
								$('.addtopicform').removeClass('addtopicform');
							});
						}
					});
				});
			});


		});










		if ($('.accordion dt:last:visible').css('display') == 'block') {
			$('.accordion').find('dt:last:visible').addClass('last-child');
		} else {
			$('.accordion').find('dd:last:visible').addClass('last-child');
		}
		$('.accordion > dt:first').addClass('first-child');
		//Get accordion panels
		var allPanels = $('.accordion > dd').hide();
		//On accordion panel top click
		console.log(extractSubjectFromURL());
		if(extractSubjectFromURL() != "false"){
			
			openSubject(extractSubjectFromURL());
		}

		$('[data-icon="c"]').click(function (e) {
						e.stopPropagation();
						var popuptext = "<span class='button editsubject' data-id='" + $(this).parent().data('id') + "' data-exam='" + $(this).parent().find('.examboard').text() + "' data-name='" + $(this).parent().find('.subjecttitle').text() + "' data-colour='" + $.trim($(this).parent().attr('class').replace("first-child", "")) + "' style='width: 70% !important; display: inline-block;'>Edit subject</span><br><br>";

						if ($('.accordion dt[data-id="' + $(this).parent().data('id') + '"]').next().find('li').not('.topicadd').size() > 0) {
							popuptext = popuptext + "<span class='button edittopics' data-id='" + $(this).parent().data('id') + "' style='width: 70% !important; display: inline-block;'>Edit topics</span><br><br>";
						}
						popuptext = popuptext + "<span class='button-red deletesubject' data-id='" + $(this).parent().data('id') + "' style='width: 70% !important; display: inline-block;'>Delete subject</span><br>";
						popup(popuptext, 0.5, 500, true, function () {

							$('.edittopics').click(function () {
								popupHide(500, function () {
									var popuptext = "<table class='topicedittable' width='100%'>";
									$('.accordion dt[data-id="' + $('.edittopics').data('id') + '"]').next().find('li').not('.topicadd').each(function () {
										popuptext = popuptext + "<tr><td><span data-id='" + $(this).data('id') + "'>" + $(this).html() + "</span></td><td width='20px' class='edittopicse'>E</td><td width='20px' class='edittopicsd'>D</td></tr>";
									});
									popuptext = popuptext + "</table>";



									popup(popuptext, 0.5, 500, true, function () {

										$('.edittopicse').click(function () {
											editelement = $(this).parent().find('td').first().find('span');
											popupHide(500, function () {
												popup("<input class='newsubject nname' data-id='" + editelement.data('id') + "' placeholder='Topic' value='" + editelement.html() + "'></input>", 0.5, 500, true, function () {

													$('.okbutton').addClass('edittopicform');
													$('.edittopicform').bind('click.add', function () {

														$.post("/edittopic.php", {
															id: editelement.data('id'),
															topic: $('.nname').val()
														}, function (data) {
															if (data == "1") {
																popupHide(500, function () {
																	var dataid = $('.nname').data('id');
																	refreshSubjects(function () {
																		if(extractSubjectFromURL() != false){
																			openSubject(extractSubjectFromURL());
																		}
																	});
																	$('.edittopicform').unbind('click.add');
																	$('.edittopicform').removeClass('edittopicform');
																});
															}
														});
													});
												});
											});
										});


										$('.edittopicsd').click(function () {
											editelement = $(this).parent().find('td').first().find('span');

											popupHide(500, function () {
												popup("Are you sure you would like to delete '" + editelement.html() + "'?<br><br><span class='button-red deleteconfirm' data-id='" + editelement.data('id') + "'>Delete this topic</span><br>", 0.5, 500, true, function () {
													$('.deleteconfirm').click(function () {
														var URL = location.pathname;
														history.pushState(null, null, URL.substring(0, URL.indexOf('topic') - 1));
														$('.popupSpinner').css('display', 'block');
														$('.okbutton').css('display', 'none');
														$('.popuptext').text('Deleting...');

														$.post("/deletetopic.php", {
															id: editelement.data('id')
														}, function (data) {

															if (data == "1") {
																popupHide(500, function () {
																	$('.popupSpinner').css('display', 'none');
																	$('.okbutton').css('display', 'block');

																	refreshSubjects(function () {
																		

																	});

																});
															}
														});
													});
												}, "Cancel");
											});
										});



									}, "Ok");

								});
							});

							$('.deletesubject').click(function () {
								popupHide(500, function () {

									popup("Are you sure you would like to delete '" + $("dt[data-id='" + $('.deletesubject').data('id') + "']").find('.examboard').html() + " " + $("dt[data-id='" + $('.deletesubject').data('id') + "']").find('.subjecttitle').html() + "'?<br><br><span class='button-red deleteconfirm' data-id='" + $('.deletesubject').data('id') + "'>Delete this subject</span><br>", 0.5, 500, true, function () {
										$('.deleteconfirm').click(function () {
											history.pushState(null, null, "/");
											var dataid = $('.deleteconfirm').data('id');
											$('.popupSpinner').css('display', 'block');
											$('.okbutton').css('display', 'none');
											$('.popuptext').text('Deleting...');

											$.post("/deletesubject.php", {
												id: dataid
											}, function (data) {

												if (data == "1") {
													popupHide(500, function () {
														$('.popupSpinner').css('display', 'none');
														$('.okbutton').css('display', 'block');

														refreshSubjects(function () {});

													});
												}
											});
										});
									}, "Cancel");
								});
							});


							$('.editsubject').click(function () {
								popupHide(500, function () {


									var popupText = "<input class='newsubject nexam' placeholder='Exam board' value='" + $('.editsubject').data('exam') + "'></input><input class='newsubject nname' data-id='" + $('.editsubject').data('id') + "' placeholder='Subject' value='" + $('.editsubject').data('name') + "'></input><select class='newsubject ncolour " + $('.editsubject').data('colour') + "'>";


									popupText = popupText + "<option value='red' class='red'";
									if ($('.editsubject').data('colour') == "red") {
										popupText = popupText + " selected ";
									}
									popupText = popupText + ">Red</option>";
									popupText = popupText + "<option value='yellow' class='yellow'";
									if ($('.editsubject').data('colour') == "yellow") {
										popupText = popupText + " selected ";
									}
									popupText = popupText + ">Yellow</option>";
									popupText = popupText + "<option value='green' class='green'";
									if ($('.editsubject').data('colour') == "green") {
										popupText = popupText + " selected ";
									}
									popupText = popupText + ">Green</option>";
									popupText = popupText + "<option value='lightblue' class='lightblue'";
									if ($('.editsubject').data('colour') == "lightblue") {
										popupText = popupText + " selected ";
									}
									popupText = popupText + ">Light blue</option>";
									popupText = popupText + "<option value='darkblue' class='darkblue'";
									if ($('.editsubject').data('colour') == "darkblue") {
										popupText = popupText + " selected ";
									}
									popupText = popupText + ">Dark blue</option>";
									popupText = popupText + "<option value='purple' class='purple'";
									if ($('.editsubject').data('colour') == "purple") {
										popupText = popupText + " selected ";
									}
									popupText = popupText + ">Purple</option>";


									popupText = popupText + "</select>";
									popup(popupText, 0.5, 500, true, function () {
										$('.ncolour').on('change', function () {
											$(this).removeClass('red yellow green lightblue darkblue purple');
											$(this).addClass($(this).find(":selected").attr('class'));
										});
										$('.okbutton').addClass('addsubjectform');
										$('.addsubjectform').bind('click.add', function () {
											$.post("/editsubject.php", {
												subject: $('.nname').val(),
												id: $('.nname').data('id'),
												exam: $('.nexam').val(),
												colour: $('.ncolour').find(":selected").attr('value')
											}, function (data) {

												if (data == "1") {
													popupHide(500, function () {
														refreshSubjects(function () {
															
														});
														$('.addsubjectform').unbind('click.add');
														$('.addsubjectform').removeClass('addsubjectform');
													});
												}
											});
										});
									});
								});

							});
						}, "Cancel");
					});


		$('.accordion > dt').click(function () {
			$(".maincontent td").animate({'background-color': 'rgba(0,0,0,0.3)'}, 500);
			//Check if panel if open
			if (!$(this).hasClass('add')) {
				if ($(this).next().css('display') == 'block') {
					//Slide up last panel

					//When complete, reset first-child and last-child classes

					//Slide up all slideouts
					allPanels.delay(200).slideUp();
					
					history.pushState(null, null, "/");


				} else {
					//Slide up all slideouts

					history.pushState(null, null, "/subject/" + $(this).data('id'));

					

					allPanels.delay(200).slideUp(function () {

					});
					$(this).next().delay(200).slideDown(function () {

					});
					

					





					//Reset first-child and last-child classes

				}
			} else {
				allPanels.delay(200).slideUp();
				
				
				popup("<input class='newsubject nexam' placeholder='Exam board'></input><input class='newsubject nname' placeholder='Subject'></input><select class='newsubject ncolour red'><option value='red' class='red'>Red</option><option value='yellow' class='yellow'>Yellow</option><option value='green' class='green'>Green</option><option value='lightblue' class='lightblue'>Light blue</option><option value='darkblue' class='darkblue'>Dark blue</option><option value='purple' class='purple'>Purple</option></select>", 0.5, 500, true, function () {
					$('.ncolour').on('change', function () {
						$(this).removeClass('red yellow green lightblue darkblue purple');
						$(this).addClass($(this).find(":selected").attr('class'));
					});
					$('.okbutton').addClass('addsubjectform');
					$('.addsubjectform').bind('click.add', function () {
						
						$.post("/addsubject.php", {
							subject: $('.nname').val(),
							exam: $('.nexam').val(),
							colour: $('.ncolour').find(":selected").attr('value')
						}, function (data) {
							var obj = $.parseJSON(data);
							if (obj.status == "ok") {
								history.pushState(null, null, "/subject/" + obj.id);
								popupHide(500, function () {
									
									refreshSubjects(function () {
										
										$('.addsubjectform').unbind('click.add');
										$('.addsubjectform').removeClass('addsubjectform');
									});

								});
							}
						});
					});
				});
			}
		});
		if (typeof functionWhenComplete !== 'undefined') {
			functionWhenComplete();
		}


	});
}

function getTopic(idVal, functionWhenComplete) {
	$('.okbutton').css('display','none');
	$('.popupSpinner').css('display','block');
	popup("Loading topic...", 0.5, 500, false, function(){
	
	getName();

	$.post("/topiccolour.php", {
		id: idVal
	}, function(data){

		if(data != '0'){
			switch (data) {
    			case 'red':
    				data = 'rgb(169,3,41)';
    				break;
    			case 'yellow':
    				data = 'rgb(168,168,3)';
    				break;
    			case 'green':
    				data = 'rgb(29,163,3)';
    				break;
    			case 'lightblue':
    				data = 'rgb(3,142,158)';
    				break;
    			case 'darkblue':
    				data = 'rgb(3,79,155)';
    				break;
    			case 'purple':
    				data = 'rgb(128,3,153)';
    				break;
			}
			$('.maincontent header td').css('background-color',data);
		}
	});

	$.post("/notesajax.php", {
		id: idVal
	},

	function (data) {
		if(location.pathname.indexOf("/topic/") > 0){
			history.pushState(null, null, location.pathname.substring(0, location.pathname.indexOf("/", location.pathname.indexOf("/subject/") + 9)) + "/topic/" + idVal);
		}else{
			history.pushState(null, null, location.pathname + "/topic/" + idVal);
		}
		$(".maincontent td").animate({'background-color': $('.slideout li[data-id="' + idVal + '"]').parent().parent().css('background-color')}, 500);
		//$('.loc').html($(this).html());
		$('.accordion').html(data);

		var holdmouse;

		

		function edit(elementSelected2) {
			popup("<span class='button editnote' data-id='" + elementSelected2.data('id') + "' style='width: 70% !important; display: inline-block;'>Edit note</span><br><br><span class='button-red deletenote' data-id='" + elementSelected2.data('id') + "' style='width: 70% !important; display: inline-block;'>Delete note</span><br>", 0.5, 500, true, function(){
							$('.editnote').bind('click.editnote', function(){
								$('.editnote').unbind('click.editnote');
								$.post("/notesnomarkdown.php", {
												id: elementSelected2.data('id')
											}, function (data) {
												var valueText = data;
												var valueBack = elementSelected2.css('background-image').replace(/url\(|\)$/ig, "");
								popup("<textarea class='newsubject notesText' data-id='" + $(this).data('id') + "' placeholder='Notes'>" + valueText + "</textarea><br><input class='backimg newsubject notesBack' placeholder='Background image URL' value='" + valueBack + "'></input>", 0.5, 500, true, function() {
									$('.okbutton').bind('click.editnoteBox', function(){
											$.post("/editnote.php", {
												id: elementSelected2.data('id'),
												notes: $('.notesText').val(),
												backimg: $('.notesBack').val()
											}, function (data) {
														console.log(data);

														$('.okbutton').unbind('click.editnoteBox');
															if (data == "1") {
																var dataid = extractTopicFromURL();
																popup("Loading notes...", 0.5, 500, false);
																getTopic(dataid, function () {
																	popupHide(500);
																});
															}
			
														});
									});
								});
											});
								
								
								});
							$('.deletenote').bind('click.deletenote', function(){

								$.post("/deletenote.php", {
									id: $('.deletenote').data('id')
								}, function (data) {
											$('.deletenote').unbind('click.deletenote');
												if (data == "1") {
													var dataid = extractTopicFromURL();
													popup("Loading notes...", 0.5, 500, false);
													getTopic(dataid, function () {
														popupHide(500);
													});
												}
											});
								});
									}, "Cancel");
		}

	
		
		$('.editpagecogtopic').bind('click.editpagecogtopic', function(){
			edit($(this).parent().parent());
		});
				$(document).on('mouseup', function () {

					if(typeof holdmouse !== 'undefined'){
					clearTimeout(holdmouse);
					}
				});
				$(document).on('touchend', function () {

					if(typeof holdmouse !== 'undefined'){
					clearTimeout(holdmouse);
					}
				});
				$('.accordion > div').not('.addnotes').on('mouseout', function () {
					
					if(typeof holdmouse !== 'undefined'){
					clearTimeout(holdmouse);
					}
				});

		$('.addnotes').on('click.addnotes', function () {

			if(Modernizr.localstorage){
				var valueText = localStorage["noteNewText"] || "";
				var valueBack = localStorage["noteNewBack"] || "";
			}else{
				var valueText = "";
				var valueBack = "";
			}

			popup("<textarea class='newsubject notesText' data-id='" + $(this).data('id') + "' placeholder='Notes'>" + valueText + "</textarea><br><input class='backimg newsubject notesBack' placeholder='Background image URL' value='" + valueBack + "'></input>", 0.5, 500, true, function () {

				$('.popup').animate({ width: '50%'}, 500);
				$('.newsubject').animate({ width: '90%'}, 500);

				$('html.localstorage .notesText').bind('input.notesTextAdd', function () {
					localStorage["noteNewText"] = $(this).val();
				});

				$('html.localstorage .notesBack').bind('input.notesBackAdd', function () {
					localStorage["noteNewBack"] = $(this).val();
				});

				$('.okbutton').addClass('addnotesform');
				$('.addnotesform').bind('click.addn', function () {
					$.post("/addnotes.php", {
						id: $('.notesText').data('id'),
						notes: $('.notesText').val(),
						backimg: $('.notesBack').val()
					}, function (data) {

						if (data == "1") {
							if (Modernizr.localstorage) {
								localStorage["noteNewText"] = "";
								localStorage["noteNewBack"] = "";
							}
							
							popupHide(500, function () {
								var dataid = $('.notesText').data('id');
								getTopic(dataid, function () {
									popupHide(500);


								});
								$('.addnotesform').unbind('click.addn');
								$('.addnotesform').removeClass('addnotesform');
							});
						}
					});
				});
				
			});


		});

		if(typeof functionWhenComplete !== 'undefined'){
			functionWhenComplete();
		}
		});

	}, "");
}

function getName() {
	$.post("/isLoggedIn.php", function (data) {
		if (data == "0") {} else {
			$(".profilepic").attr("src", "/pic.php?timestamp=" + new Date().getTime());
			// if (data.substr(data.length - 1) == "s") {
				// $('.name').html("<span class='namelong'>" + data + "' Hydroelectric Facility</span><span class='nameshort'>" + data + "</span>");
				$('.name').html("<span class='namelong'>" + data + "</span><span class='nameshort'>" + data + "</span>");
			// } else {
				// $('.name').html("<span class='namelong'>" + data + "'s Hydroelectric Facility</span><span class='nameshort'>" + data + "</span>");
			// }

		}
	});
}




//Anonymous function which runs itself thanks to (jQuery); at end
$(document).ready(function () {

	new FastClick(document.body);

	$.post("/isinstalled.php", function (data) {
		if (data == "0") {
			window.location = "/install.php";
		}
	});

	$('.editpagebutton').bind('click.editpage', function(){
			$('.editpagecog').toggle();
		});
	
	$('.home').on('click', function(){
			// $('.maincontent').css('position','absolute');
			// $('.maincontent').animate({ left: 10em });
			
			refreshSubjects(function(){
				history.pushState(null, null, window.location.pathname.substr(0,window.location.pathname.indexOf('topic')-1));
				$(".maincontent td").animate({'background-color': 'rgba(0,0,0,0.3)'}, 500);
				$('.loc').html('');
			}, "Loading subjects...");

		});

	$('.importexportbutton').on('click', function(){

			
			popup('<a class="button" href="/export.php">Export</a><br><br><span class="button importbutton">Import</span><br><br>Importing will overwrite ALL data<br>', 0.5, 500, true, function(){
				$('.importbutton').bind('click.importbutton', function(){
					$('.importbutton').unbind('click.importbutton');
					popup('<textarea class="newsubject pastearea" placeholder="Paste the contents of the backup file here"></textarea><br>', 0.5, 500, true, function(){
						
						$('.okbutton').bind('click.importdata', function(){

							$('.okbutton').unbind('click.importdata');

							$.post('/import.php', {
								'texttoimport': $('.pastearea').val()
							}, function(data){
								console.log(data);
								if(data=='1'){
									window.location = '/';
								}
							});
						});
					}, 'Import');
				});
			});

		});

	$('.optionsbutton').on('click', function(){

			var originalname;
			$.post("/isLoggedIn.php",
					function(data){
						originalname = data;
			popup('<input type="text" class="newsubject namebox" id="passwordbox" placeholder="Name" value="' + originalname + '"></input><br><input type="text" class="newsubject emailbox" id="passwordbox" placeholder="Email"></input><br><input type="password" class="newsubject passbox" id="passwordbox" placeholder="Password"></input>', 0.5, 500, true, function(){
				$('.okbutton').bind('click.editoptions', function(){
					$('.okbutton').unbind('click.editoptions');
					var password = CryptoJS.SHA256($('.passbox').val()).toString(CryptoJS.enc.Hex);
  		 			var name = $('.namebox').val();
  		 			var email = md5($('.emailbox').val());
  		 			$('.popuptext').html('Loading...');
  		  		  	$.post("/editoptions.php", {
						"password": password,
						"name": name,
						"email": email
					},
					function(data){
						if(data == "1"){
							refreshSubjects();
						}
					});
  		  		  });
			}, 'Save');

			});
		});


	$('.re').click(function () {
		location.reload(true);
	});

	$('.okbutton').click(function () {
		$('.popup').fadeOut(500, function () {
			$('.overlay').fadeOut(500, function () {
				if (typeof flashAmber === 'undefined') {

				} else {
					clearTimeout(flashAmber);
				}
			});
		});
	});

	$('html.touch header').click(function (e) {
		e.stopPropagation();
		if ($('html.touch .hoverText .options').css('visibility') == 'visible') {
			$('html.touch .hoverText .options').css('visibility', 'hidden');
			$('html.touch .hoverText').css('background-color', 'rgba(0,0,0,0)');
		} else {
			$('html.touch .hoverText .options').css('visibility', 'visible');
			$('html.touch .hoverText').css('background-color', 'rgba(0,0,0,0.5)');
		}
	});

	$('html.touch').click(function () {
		$('html.touch .hoverText .options').css('visibility', 'hidden');
			$('html.touch .hoverText').css('background-color', 'rgba(0,0,0,0)');
	});

	


	$.post("/isLoggedIn.php", function (data) {
		if (data == "0") {
			popupHide();
		} else {
			if(location.pathname.indexOf('topic') < 0){
				getSubjects(popupHide());
			}else{
				getTopic(location.pathname.substr(location.pathname.indexOf('topic') + 6, location.pathname.length), popupHide());
			}
			
		}
	});






	$(".passwordbox").keyup(function (e) {
		if (e.keyCode == 13) {
			$('.loginbutton').click();
		}
	});

	$('.logoutbutton').click(function () {
		$('.passwordbox').attr('disabled', 'disabled');
		var htmlheight = $('html').height();
		htmlheight = "-" + htmlheight + "px";
		$('.logintable').css('top', htmlheight);
		$('.logintable').css('display', 'table');

		$.post("/logoutajax.php", function (data) {

			if (data == "1") {
				$('.i1').css('background-color', '#303030');
				$('.i2').css('background-color', '#303030');
				$('.i3').css('background-color', '#303030');
				var flashRed = setInterval(function () {
					if ($('.i1').css('background-color') == 'rgb(48, 48, 48)') {

						$('.i1').css('background-color', 'red');
					} else {

						$('.i1').css('background-color', '#303030');
					}
				}, 500);
				$('.logintable').animate({
					'top': '0'
				}, 2000, function () {
					setTimeout(function () {
						$('.passwordbox').removeAttr('disabled');
						clearTimeout(flashRed);
						$('.i1').css('background-color', '#303030');
						$('.i2').css('background-color', 'orange');
					}, 2000);


				});

			}
		});
	});
	//Login button for login page
	$('.loginbutton').click(function () {
		$('.passwordbox').blur();
		$('.passwordbox').attr('disabled', 'disabled');
		var flashAmber = setInterval(function () {
			if ($('.i2').css('background-color') == 'rgb(48, 48, 48)') {

				$('.i2').css('background-color', 'orange');
			} else {

				$('.i2').css('background-color', '#303030');
			}
		}, 500);

		$.post("/loginajax.php", {
			"password": CryptoJS.SHA256($('.passwordbox').val()).toString(CryptoJS.enc.Hex)
		},

		function (data) {

			if (data == "0") {
				//Make card visible
				$('body').css('overflow', 'hidden');
				$('.card').css('display', 'block');
				//Get height of page
				var htmlh = $('html').height();
				//Set height of page to minus
				htmlh = "-" + htmlh + "px";
				//Set last variable to card margin-top
				$('.card').css('margin-top', htmlh);
				//Animate swipe of card
				$('.card').animate({
					'margin-top': '1000px'
				}, 3000, function () {
					$('body').css('overflow', 'auto');
				});
				//Set timeout for indicators
				getSubjects();
				setTimeout(function () {
					clearTimeout(flashAmber);

					$('.i1').css('background-color', 'red');
					$('.i2').css('background-color', '#303030');
					setTimeout(function () {
						$('.i1').css('background-color', '#303030');
						setTimeout(function () {
							$('.i1').css('background-color', 'red');
							setTimeout(function () {
								$('.i1').css('background-color', '#303030');
								setTimeout(function () {
									$('.i1').css('background-color', 'red');
									setTimeout(function () {
										$('.i1').css('background-color', '#303030');
										$('.i2').css('background-color', 'orange');
										$('.passwordbox').removeAttr('disabled');

									}, 1000);
								}, 500);
							}, 500);
						}, 500);
					}, 500);
				}, 2000);
			}
			if (data == "1") {
				//Make card visible
				$('body').css('overflow', 'hidden');
				$('.card').css('display', 'block');
				//Get height of page
				var htmlh = $('html').height();
				//Set height of page to minus
				htmlh = "-" + htmlh + "px";
				//Set last variable to card margin-top
				$('.card').css('margin-top', htmlh);
				//Animate swipe of card
				$('.card').animate({
					'margin-top': '1000px'
				}, 3000, function () {
					$('.card').css('display', 'none');
					$('body').css('overflow', 'auto');
				});
				getSubjects(function () {


					//Set timeout for indicators
					setTimeout(function () {
						clearTimeout(flashAmber);

						$('.i3').css('background-color', '#00FF00');
						$('.i2').css('background-color', '#303030');
						setTimeout(function () {
							$('.i3').css('background-color', '#303030');
							setTimeout(function () {
								$('.i3').css('background-color', '#00FF00');
								setTimeout(function () {
									$('.i3').css('background-color', '#303030');
									setTimeout(function () {
										$('.i3').css('background-color', '#00FF00');
										var flashGreen = setInterval(function () {
											if ($('.i3').css('background-color') == '#303030') {
												$('.i3').css('background-color', 'green');
											} else {
												$('.i3').css('background-color', '#303030');
											}
										}, 500);
										$('.logintable').animate({
											'top': htmlh
										}, 2000, function () {
											$('.i3').css('background-color', 'orange');
											$('.logintable').css('display', 'none');
											clearTimeout(flashGreen);
											$('.passwordbox').val('');
										});
									}, 500);
								}, 500);
							}, 500);
						}, 500);
					}, 2000);
				});
			}

			if (data == "2") {
				//Make card visible
				$('body').css('overflow', 'hidden');
				$('.card').css('display', 'block');
				//Get height of page
				var htmlh = $('html').height();
				//Set height of page to minus
				htmlh = "-" + htmlh + "px";
				//Set last variable to card margin-top
				$('.card').css('margin-top', htmlh);
				//Animate swipe of card
				$('.card').animate({
					'margin-top': '1000px'
				}, 3000, function () {
					$('body').css('overflow', 'auto');
				});
				//Set timeout for indicators
				setTimeout(function () {
					clearTimeout(flashAmber);

					$('.i1').css('background-color', 'red');
					$('.i2').css('background-color', '#303030');
					setTimeout(function () {
						$('.i1').css('background-color', '#303030');
						setTimeout(function () {
							$('.i1').css('background-color', 'red');
							setTimeout(function () {
								$('.i1').css('background-color', '#303030');
								setTimeout(function () {
									$('.i1').css('background-color', 'red');
									setTimeout(function () {
										$('.i1').css('background-color', '#303030');
										$('.i2').css('background-color', 'orange');
										$('.passwordbox').removeAttr('disabled');
										popup("Database error, check your database settings");
									}, 1000);
								}, 500);
							}, 500);
						}, 500);
					}, 500);
				}, 2000);
			}
			if (data == "3") {
				//Make card visible
				$('body').css('overflow', 'hidden');
				$('.card').css('display', 'block');
				//Get height of page
				var htmlh = $('html').height();
				//Set height of page to minus
				htmlh = "-" + htmlh + "px";
				//Set last variable to card margin-top
				$('.card').css('margin-top', htmlh);
				//Animate swipe of card
				$('.card').animate({
					'margin-top': '1000px'
				}, 3000, function () {
					$('body').css('overflow', 'auto');
				});
				//Set timeout for indicators
				setTimeout(function () {
					clearTimeout(flashAmber);

					$('.i1').css('background-color', 'red');
					$('.i2').css('background-color', '#303030');
					setTimeout(function () {
						$('.i1').css('background-color', '#303030');
						setTimeout(function () {
							$('.i1').css('background-color', 'red');
							setTimeout(function () {
								$('.i1').css('background-color', '#303030');
								setTimeout(function () {
									$('.i1').css('background-color', 'red');
									setTimeout(function () {
										$('.i1').css('background-color', '#303030');
										$('.i2').css('background-color', 'orange');
										$('.passwordbox').removeAttr('disabled');
										popup("Too many incorrect passwords, please try again in 10 minutes");
									}, 1000);
								}, 500);
							}, 500);
						}, 500);
					}, 500);
				}, 2000);

			}
		});



	});


});