String.prototype.format = function() {
	var formatted = this;
	for (var i = 0; i < arguments.length; i++){
		var regexp = new RegExp('\\{'+i+'\\}', 'gi');
		formatted = formatted.replace(regexp, arguments[i]);
	}
	return formatted;
};

Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

(function($){
	$.theme = {
		intervals: [],
		navigation: {
			auto: true,
			init: function(){
				if (window.location.pathname!=null && window.location.pathname!="" && $("section[data-page='mainpage']").size())
				{
					var cur = (window.location.pathname).replace(/^\/?\w{2,3}-\w{2}\//, "").replace(/\/$/, "");
					var o = $("section"+($("section[data-localised='"+cur+"']").size() ? "[data-localised='"+cur+"'" : "[data-page='"+cur+"']")).offset();
					if (o!=null)
						$(document).scrollTop(o.top-107);
				}
				else
					var curr = $.theme.navigation.current_visible();
				if (curr!==false)
					$("header ul.main_menu li a[data-link='"+curr+"']").addClass("curr");
				$.theme.navigation.listeners.init();
				$(".main_menu a, #subnav a, footer nav a").each(function(){
					if ($(this).attr("href")!=null)
					{
						var m = $(this).attr("href").match(/(\w{2,3}-\w{2})\/(.+)\/$/);
						if (m!=null && m[2]!=null && ($("section[data-page='"+m[2]+"']").size() || $("section[data-localised='"+m[2]+"']").size()))
						{
							$(this).removeAttr("href");
							$(this).attr("data-link", m[2]);
						}
					}
				});
				$.theme.show_emails();
				$.theme.svgs();
				$(document).ready(function(){$("body").addClass("animations")});
				$.theme.navigation.mobile_menu();
			},
			current_visible: function(){
				var t = $(window).scrollTop()+$(window).height()/2.5;
				var o = null;
				var found = false;
				$("section[data-page]").each(function(){
					o = $(this).offset();
					if (o.top<=t && (o.top+$(this).height())>=t)
					{
						found = $(this).attr("data-page");
						if ($(this).attr("data-localised"))
							found = $(this).attr("data-localised");
						return true;
					}
				});
				if (found!==false)
					return found;
				return false;
			},
			listeners: {
				init: function(){
					$.theme.navigation.listeners.scroll();
					$.theme.navigation.listeners.click();
					$.theme.navigation.listeners.languages();
				},
				scroll: function(){
					$(document).scroll(function(e){
						var curr = $.theme.navigation.current_visible();
						if ($.theme.navigation.auto===true)
						{
							$("header ul.main_menu li a.curr > span:empty").height(0);
							$("header [data-link]").removeClass("curr");
						}
						if (curr!=="mainpage" && curr!==false && !$("header [data-link='"+curr+"']").hasClass("curr") && $.theme.navigation.auto===true)
						{
							$("header [data-link='"+curr+"']").addClass("curr");
							$("header .main_menu .current_page_item").removeClass("current_page_item");
						}
						else if (curr==="mainpage")
							$("header [data-link]").removeClass("curr");
						if ($("section[data-localised='"+curr+"'][data-title]").size() && $("title").attr("data-pagename")!=null)
							document.title = ($("section[data-localised='"+curr+"'][data-title]").attr("data-title")!="" ? $("section[data-localised='"+curr+"'][data-title]").attr("data-title")+" – " : "")+$("title").attr("data-pagename");
						else if ($("section[data-page='"+curr+"'][data-title]").size() && $("title").attr("data-pagename")!=null)
							document.title = ($("section[data-page='"+curr+"'][data-title]").attr("data-title")!="" ? $("section[data-page='"+curr+"'][data-title]").attr("data-title")+" – " : "")+$("title").attr("data-pagename");
						if (Modernizr.history && curr!==false && window.location.pathname!="/"+$("html[data-lang]").attr("data-lang")+"/"+curr+"/" && curr!="404")
						{
							if (curr==="mainpage")
								history.replaceState(undefined, undefined, "/"+$("html[data-lang]").attr("data-lang")+"/");
							else if (curr!=="subpage")
								history.replaceState(undefined, undefined, "/"+$("html[data-lang]").attr("data-lang")+"/"+curr+"/");
						}
						return false;
					});
				},
				click: function(){
					$(document).on("click","header [data-link]:not(.curr), footer nav a[data-link]", function(){
						if ($(this).attr("data-link")!="mainpage" && Modernizr.history && window.location.pathname!="/"+$("html[data-lang]").attr("data-lang")+"/"+$(this).attr("data-link")+"/")
							history.pushState(undefined, undefined, "/"+$("html[data-lang]").attr("data-lang")+"/"+$(this).attr("data-link")+"/");
						var o = $("section"+($("section[data-localised='"+$(this).attr("data-link")+"']").size() ? "[data-localised='"+$(this).attr("data-link")+"']" : "[data-page='"+$(this).attr("data-link")+"']")).offset();
						$("header ul.main_menu li a.curr > span:empty").height(0);
						$("header [data-link]").removeClass("curr");
						$("header .main_menu .current_page_item").removeClass("current_page_item");
						$("header ul.main_menu li a[data-link='"+$(this).attr("data-link")+"']").addClass("curr");
						$.theme.navigation.auto = false;
						$("html,body").stop(true, false);
						$("html,body").animate({scrollTop: o.top-107}, (o.top/$(window).height())*100+450, "easeOutQuart", function(){$.theme.navigation.auto=true});
					});
				},
				languages: function(){
					$(document).on("click",function(e){
						if ($(e.target).is("body > header nav .country,body > header nav .country *"))
						{
							$("body > header nav .country > ul").stop(true,false);
							$("body > header nav .country").toggleClass("opened");
							$("body > header nav .country > div > ul").slideToggle(250);
						}
						else if (!$(e.target).is("body > header nav .country,body > header nav .country *") && $("body > header nav .country > div > ul").is(":visible"))
						{
							$("body > header nav .country > ul").stop(true,false);
							$("body > header nav .country").removeClass("opened");
							$("body > header nav .country > div > ul").slideUp(250);
						}
					});
				}
			},
			mobile_menu: function(){
				$("body>header>nav").click(function(e){
					if ($(window).width()<=1024 && e.offsetX>=0 && e.offsetX<=52 && e.clientY<=60)
					{
						if (!$("body").hasClass("show_menu"))
						{
							var top = $(document).scrollTop();
							$("body").addClass("show_menu");
							$("body").css({top: "-"+top+"px"});
						}
						else
						{
							var top = parseFloat($("body").css("top"));
							$("body").removeClass("show_menu");
							$(document).scrollTop(-1*top);
						}
					}
				});

				$(document).on("click", "body > header.show_menu", function(e){
					var h = $(this).height();
					if (e.offsetY>h && !$(e.target).is("#mainmenu, #mainmenu *"))
					{
						$("body>header").removeClass("show_menu");
						$("body").css({"overflow": "auto"});
					}
				});

				$("body > header #mainmenu .mobile_nav ul li.lang").click(function(){
					$(this).children("a").toggleClass("opened");
					if (!$("body > header #mainmenu .mobile_nav .countries").is(":visible"))
					{
						$("body > header #mainmenu .mobile_nav .countries").show();
						var h = $("body > header #mainmenu .mobile_nav .countries").outerHeight();
						$("body > header #mainmenu .mobile_nav .countries").hide();
					}
					$("body > header #mainmenu .mobile_nav .countries").slideToggle(200);
					if (h!=null)
						$("body > header #mainmenu").animate({scrollTop: "+="+h}, 200);
					else
						$("body > header #mainmenu .mobile_nav .countries ul ul").fadeOut(250);
				});

				$("body > header #mainmenu .mobile_nav .countries span").click(function(){
					if ($(this).next("ul").is(":visible"))
						$(this).next("ul").fadeOut(250);
					else
					{
						$("body > header #mainmenu .mobile_nav .countries ul ul").fadeOut(250);
						$(this).next("ul").fadeIn(250);
					}
				});
			}
		},
		show_emails: function(){
			$("[data-email][data-domain][data-tld]").each(function(){
				$(this).html("<a href='mailto:"+$(this).attr("data-email")+"@"+$(this).attr("data-domain")+"."+$(this).attr("data-tld")+"'>"+($(this).attr("data-text")!=null ? $(this).attr("data-text") : $(this).attr("data-email")+"@"+$(this).attr("data-domain")+"."+$(this).attr("data-tld"))+"</a>");
			});
		},
		svgs: function(){
			if (!Modernizr.svg)
				return false;
			$("img[data-svg]").each(function(){
				$(this).attr("src",$(this).attr("data-svg"));
			});
		}
	}

	jQuery(window).ready(function(){
		//Navigation JavaScripts
		$.theme.navigation.init();

		// Cookie law strip
		if ($("#cookie-strip").size())
		{
			$("html").css({paddingBottom: $("#cookie-strip").outerHeight()});
			$(window).resize(function(){
				if ($("#cookie-strip").size())
					$("html").css({paddingBottom: $("#cookie-strip").outerHeight()});
			});
		}
		$("#cookie-strip nav a.close").click(function(){
			var d = new Date();
			d.setTime(d.getTime()+(365*24*60*60*1000));
			document.cookie = "cookie_law=agree; expires="+d.toUTCString()+"; path=/";
			$("html").animate({paddingBottom: 0}, 250, "easeOutQuart");
			$("#cookie-strip").height($("#cookie-strip").height());
			$("#cookie-strip").css({"overflow-y": "hidden"});
			$("#cookie-strip").animate({height: 0, opacity: 0}, 250, "easeOutQuart", function(){
				$(this).remove();
			});
		});

		// Remember language and location
		$(document).on("click", "a", function(){
			if ($(this).attr("href")!=null)
			{
				var m = ($(this).attr("href")+"").match(/\/?([a-z]{2,3}-[a-z]{2})(\/|$)/);
				var m2 = (document.cookie+"").match(/prefered_lang=([a-z]{2,3}-[a-z]{2})(;|$)/);
				if (m2==null || m2[1]==null || (((m==null || m[1]==null) && (m2==null || m2[1]==null || m2[1]!="int-en")) || m2[1]!=m[1]))
				{
					var d = new Date();
					d.setTime(d.getTime()+(365*24*60*60*1000));
					document.cookie = "prefered_lang="+m[1]+"; expires="+d.toUTCString()+"; path=/";
				}
			}
		});

		//Solutions - Quotes slideshow
		$(".quotes ul").attr("data-slide", 0);
		$(".quotes ul").each(function(){
			$(this).append($(this).children("li:eq(0)").clone());
		});
		function quotes_interval(quotes, dir){
			quotes.stop(true, false);
			if (quotes.closest(".quotes").attr("data-interval")!=null)
				clearInterval(quotes.closest(".quotes").attr("data-interval"));
			if (dir!=null && dir==1)
			{
				quotes.animate({scrollLeft: "+="+quotes.width()}, 650, "easeOutQuart", function(){
					$(this).attr("data-slide", (parseFloat($(this).attr("data-slide"))+1));
					if (parseFloat($(this).attr("data-slide"))+1>=$(this).children("li").size())
					{
						$(this).scrollLeft(0);
						$(this).attr("data-slide", 0);
					}
				});
			}
			else if (dir!=null && dir==-1)
			{
				if (parseFloat(quotes.attr("data-slide"))==0)
				{
					quotes.prepend(quotes.children("li:eq("+(quotes.children("li").size()-2)+")").clone());
					quotes.scrollLeft(quotes.width());
				}
				quotes.animate({scrollLeft: "-="+quotes.width()}, 650, "easeOutQuart", function(){
					$(this).attr("data-slide", (parseFloat($(this).attr("data-slide"))-1));
					if (parseFloat($(this).attr("data-slide"))==-1)
					{
						$(this).children("li:eq(0)").remove();
						$(this).attr("data-slide", (quotes.children("li").size()-2));
						$(this).scrollLeft(parseFloat($(this).attr("data-slide"))*quotes.width());
					}
				});
			}
			var inter = setInterval(function(){
				quotes.animate({scrollLeft: "+="+quotes.width()}, 650, "easeOutQuart", function(){
					$(this).attr("data-slide", (parseFloat($(this).attr("data-slide"))+1));
					if (parseFloat($(this).attr("data-slide"))+1>=$(this).children("li").size())
					{
						$(this).scrollLeft(0);
						$(this).attr("data-slide", 0);
					}
				});
			}, 10000);
			quotes.closest(".quotes").attr("data-interval", inter);
		}
		$(".quotes ul").each(function(k,v){
			$(this).scrollLeft(0);
			quotes_interval($(".quotes ul:eq("+k+")"));
		});
		$(window).resize(function(){
			$(".quotes ul").each(function(k,v){
				$(this).stop(true, false);
				$(this).scrollLeft($(this).width()*(parseFloat($(this).attr("data-slide"))+1));
			});
		});
		if ($("section[data-page='solutions'] div.quotes").size())
		{
			$(document).on("click","section[data-page='solutions'] div.quotes",function(e){
				if (e.offsetX<0)
					quotes_interval($(this).children("ul"), -1);
				else if (e.offsetX>$(this).width())
					quotes_interval($(this).children("ul"), 1);
			});
		}

		//Prepaid cards survey
		if ($("#choose_card_survey").size())
		{
			$.choose_card_survey = {
				question: -2,
				questions: [],
				answers: [],
				show_question: function(){
					if ($("#survey_questions").hasClass("hidden"))
						$("#survey_questions").removeClass("hidden");
					else
						this.answers.push(parseFloat($("#choose_card_survey #survey_questions input[type='radio']:checked").attr("data-answer")));
					this.question++;
					if (this.questions[this.question]!=null)
					{
						var html = (this.question+1)+". "+this.questions[this.question].question+"<br />";
						var answers = 0;
						$.each(this.questions[this.question].answers, function(k,v){
							if (v.hide_if!=null){
								for (i=1;i<($.choose_card_survey.question+1);i++)
									v.hide_if = v.hide_if.replace(new RegExp(i+"=", "g"), "\$.choose_card_survey.answers["+(i-1)+"]==");
							}
							if (v.hide_if==null || (!eval(v.hide_if)))
							{
								html += "<label><input type='radio' name='question"+this.question+"' data-answer='"+(k+1)+"'><span></span> "+v.answer+"</label>";
								answers++;
							}
						});
						if (!answers)
							this.send_answers();
						else
							$("#survey_questions").html(html);
					}
					else if (this.questions.length==this.question)
						this.send_answers();
				},
				send_answers: function(){
					$.post(window.location.pathname+"?ajax=card_survey", {"step":"answers","answers":this.answers}, function(r){
						if (r==null || r=="" || r.status==null || r.status==="error")
						{
							alert("Sorry, something went wrong.");
							return false;
						}
						$("#survey_questions").after("<div id='survey_result'></div>");
						$("#survey_result").html("<div class='title'>"+r.title+"</div>");
						var o = $("#survey_result").offset();
						if (o!=null)
							$("body,html").animate({scrollTop: (o.top-$(window).height()/6)}, 350, "easeOutQuart");
						$.each(r.result, function(k,v){
							$("#survey_result").append("<div class='card "+(r.result.length>1 ? (k==0 ? "fleft" : "fright") : "")+"'><img src='"+v.image+"' alt='card' title='' style='max-width: 100%' /><br /><div class='title'>"+v.title+"</div><div class='subtitle'><a href='"+v.link+"'>"+v.subtitle+"</a></div></div>");
							if (r.or!=null && k==0)
								$("#survey_result").append(r.or);
						});
						$("#survey_result").append("<div><a class='again'>"+r.again+"</a></div>");
					});
				},
				reset: function(){
					$("#survey_result").html("");
					$("#survey_questions").addClass("hidden");
					var o = $("#survey_questions").offset();
					if (o!=null)
						$("body,html").animate({scrollTop: o.top-$(window).height()/6}, 250, "easeOutQuart");
					$.choose_card_survey.question = -1;
					$.choose_card_survey.answers = new Array();
					$.choose_card_survey.show_question();
				}
			};
			$(document).on("click","#choose_card_survey .go:not(.active)",function(){
				$(this).addClass("active");
				$.post(window.location.pathname+"?ajax=card_survey", {"step":"questions"}, function(r){
					if (r==null || r=="" || r.status==null || r.status==="error")
					{
						alert("Sorry, something went wrong.");
						return false;
					}
					$.choose_card_survey.questions = r.questions;
					if ($.choose_card_survey.question===-1)
						$.choose_card_survey.show_question();
				});
				$(this).after("<div id='survey_questions' class='hidden'></div>");
				$(this).fadeTo(150, 0.001);
				var o = $("#survey_questions").offset();
				if (o!=null)
					$("body,html").animate({scrollTop: o.top-$(window).height()/6}, 250, "easeOutQuart");
				$("#survey_questions").animate({paddingBottom: 35, minHeight: (270-45)}, 250, "easeOutQuart", function(){
					$("#choose_card_survey .go").remove();
					$(this).css({minHeight: 270});
					if ($.choose_card_survey.question===-2 && $.choose_card_survey.questions[0]!=null)
					{
						$.choose_card_survey.question = -1;
						$.choose_card_survey.show_question();
					}
					else
						$.choose_card_survey.question++;
				});
			});
			$(document).on("change","#choose_card_survey #survey_questions input[type='radio']", function(){
				$.choose_card_survey.show_question();
			});
			$(document).on("click","#choose_card_survey #survey_result a.again", function(){
				$.choose_card_survey.reset();
			});
		}

		// FAQ
		/*if ($("section[data-page='support/faq']").size())
		{
			$.faq = (function($){
				// Listeners
				($.fn.faq_listeners = function(){
					$(document).on("click",".categories a[data-category]", function(){$.fn.faq_change_category($(this).attr("data-category"))});
					$(document).on("click","section[data-page='support/faq'] > .answers ol a[data-question]", function(){$.fn.faq_select_question($(this).attr("data-question"))});
					$("input[name='search']").on("input", function(){$.fn.faq_search()});
					$("input[name='search']").on("keyup", function(e){if (e.keyCode==13) $.fn.faq_search()});
				})();
				// Select Category
				$.fn.faq_change_category = function(cat){
					$("input[name='search']").val("");
					$.fn.faq_reset();
					$(".categories a[data-category]").removeClass("curr");
					$(".categories a[data-category='"+cat+"']").addClass("curr");
					$("section[data-page='support/faq'] > div.answers").show();
					$("section[data-page='support/faq'] > div.answers [data-category]").hide();
					$("section[data-page='support/faq'] > div.answers [data-category='"+cat+"']").show();
					var o = $("section[data-page='support/faq'] > div.answers").offset();
					if (o!=null)
						$("body,html").animate({scrollTop: o.top-$(window).height()/8}, 250, "easeOutQuart");
				};
				// Select Question
				$.fn.faq_select_question = function(question){
					var o = $("section[data-page='support/faq'] > .answers h5[data-question='"+question+"']").parent("div").offset();
					if (o!=null)
					{
						$("section[data-page='support/faq'] > .answers h5[data-question='"+question+"']").parent("div").addClass("curr");
						$("body,html").animate({scrollTop: (o.top-($(window).height()/2)+($("section[data-page='support/faq'] > .answers h5[data-question='"+question+"']").parent("div").outerHeight()/2))}, 250, "easeOutQuart", function(){
							setTimeout(function(){$("section[data-page='support/faq'] > .answers h5[data-question='"+question+"']").parent("div").removeClass("curr")}, 750);
						});
					}
				};
				// Search
				$.fn.faq_search = function(){
					if ($("input[name='search']").val()!="")
					{
						$(".categories a[data-category]").removeClass("curr");
						var search = ($("input[name='search']").val()).split(" ");
						$.fn.faq_reset();
						$("section[data-page='support/faq'] > .answers .subcategories").hide();
						$("section[data-page='support/faq'] > div.answers").show();
						$("section[data-page='support/faq'] > div.answers [data-category]").show();
						var pass = true;
						var re = null;
						var question = null;
						var answer = null;
						$("section[data-page='support/faq'] > div.answers h5[data-question]").each(function(){
							question = $(this).text();
							answer = $(this).next(".answer").text();
							$.each(search, function(k,v){
								re = new RegExp(v,"gi");
								if (!re.test(question) && !re.test(answer))
								{
									pass = false;
									return false;
								}
							});
							if (!pass)
							{
								$(this).hide();
								$(this).next(".answer").hide();
								$("[data-question='"+$(this).attr("data-question")+"']").parent().hide();
							}
							pass = true;
						});
						$("section[data-page='support/faq'] > div.answers [data-category] > h4").each(function(){
							if ($(this).next("ol").children("li:visible").size()==0)
							{
								$(this).hide();
								$(this).next("ol").hide();
							}
						});
						if (!$("section[data-page='support/faq'] > div.answers [data-category] > div:visible").size())
						{
							$("section[data-page='support/faq'] > div.answers").hide();
							$("section[data-page='support/faq'] > div.no-results").show();
						}
					}
					else
						$.fn.faq_reset();
				};
				$.fn.faq_reset = function(){
					$("section[data-page='support/faq'] *").removeAttr("style");
					$("section[data-page='support/faq'] > .answers .subcategories").removeAttr("style");
				};

				// Scroll
				$(document).scroll(function(){
					var o = $("section[data-page='support/faq'] > .answers .tanswers ~ [data-category]:visible").offset();
					if (o==null || o.top-$(window).height()/2>$(document).scrollTop())
						return true;
					$("section[data-page='support/faq'] > div.answers [data-category]:visible > div[data-subcategory]").each(function(){
						var o = $(this).offset();
						if (o==null || o.top-$(window).height()/2>=$(document).scrollTop())
						{
							$("section[data-page='support/faq'] > .answers .subcategories:visible li").removeClass("current");
							$("section[data-page='support/faq'] > .answers .subcategories:visible li[data-subcategory='"+$(this).attr("data-subcategory")+"']").addClass("current");
							return false;
						}
					});

					var o = $("section[data-page='support/faq'] > .answers .tanswers ~ [data-category]:visible").offset();
					if (o!=null && ($(document).scrollTop()-o.top+29+70)>=0)
					{
						var top = ($(document).scrollTop()-o.top+29+70);
						if (top<=29)
							top = 29;
						else if (top>=($("section[data-page='support/faq'] > .answers .tanswers ~ [data-category]:visible").height()-$("section[data-page='support/faq'] > .answers .tanswers ~ [data-category]:visible .subcategories").height()-70+29))
							top = ($("section[data-page='support/faq'] > .answers .tanswers ~ [data-category]:visible").height()-$("section[data-page='support/faq'] > .answers .tanswers ~ [data-category]:visible .subcategories").height()-70+29);
						$("section[data-page='support/faq'] > .answers [data-category]:visible .subcategories:visible").css({"top": top});
					}
				});

				// Subcategory
				$(document).on("click", "section[data-page='support/faq'] > .answers .subcategories:visible li[data-subcategory]", function(){
					var o = $("section[data-page='support/faq'] > div.answers [data-category] > div[data-subcategory='"+$(this).attr("data-subcategory")+"']:eq(0)").offset();
					if (o!=null)
					{
						$("section[data-page='support/faq'] > div.answers [data-category] > div[data-subcategory='"+$(this).attr("data-subcategory")+"']").addClass("curr");
						setTimeout(function(){$("section[data-page='support/faq'] > div.answers [data-category] > div[data-subcategory].curr").removeClass("curr")}, 750);
						$("body,html").animate({scrollTop: o.top-$(window).height()/2}, 350, "easeOutQuart");
					}
				});
			})(jQuery);
		}*/

		// Fees
		if ($("section[data-page='products/prepaid-cards/fees']").size())
		{
			$.post(window.location.pathname+"?ajax=fees", {}, function(r){
				if (r==null || r.status==null || r.status!="success")
					return false;
				var html = "";
				var currencies = new Array();

				$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]").each(function(){
					if (r.fees[$(this).attr("data-card")]==null)
						return true;
					$(this).children("table").remove();
					html = "";
					$.each(r.fees[$(this).attr("data-card")], function(category, fees){
						html += "<table>";
							html += "<thead>";
								html += "<th>"+(category!=parseFloat(category) ? category : "")+"</th>";
								if (fees[Object.keys(fees)[0]].GBP!=null)
									html += "<th>GBP</th>";
								if (fees[Object.keys(fees)[0]].EUR!=null)
									html += "<th>EUR</th>";
								if (fees[Object.keys(fees)[0]].USD!=null)
									html += "<th>USD</th>";
							html += "</thead>";
							html += "<body>"
								$.each(fees, function(fee, values){
									html += "<tr>";
										html += "<td>"+fee.replace(/\n/, "<br/>")+"</td>";
										if (values.GBP!=null)
											html += "<td>"+(values.GBP!=parseFloat(values.GBP) ? values.GBP : (values.GBP===0 ? r.translations.free : (values.unit!=null ? values.unit.replace(/%(d|f|g)/, values.GBP).replace(/%%/, "%") : "£ "+values.GBP.format(2))))+"</td>";
										if (values.EUR!=null)
											html += "<td>"+(values.EUR!=parseFloat(values.EUR) ? values.EUR : (values.EUR===0 ? r.translations.free : (values.unit!=null ? values.unit.replace(/%(d|f|g)/, values.EUR).replace(/%%/, "%") : values.EUR.format(2)+" €")))+"</td>";
										if (values.USD!=null)
											html += "<td>"+(values.USD!=parseFloat(values.USD) ? values.USD : (values.USD===0 ? r.translations.free : (values.unit!=null ? values.unit.replace(/%(d|f|g)/, values.USD).replace(/%%/, "%") : "$ "+values.USD.format(2))))+"</td>";
									html += "</tr>";
								});
							html += "</body>"
						html += "</table>";
					});
					$(this).append(html);
				});
			});

			if (window.location.hash!=null && window.location.hash!="")
			{
				$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card] .fees_navigation").show();
				switch (window.location.hash)
				{
					case "#visa":
					case "visa":
						$("[data-card]").hide();
						$("[data-card='visa']").show();
						$("section[data-page='products/prepaid-cards/fees'] nav.cards a").removeClass("selected");
						$("section[data-page='products/prepaid-cards/fees'] nav.cards a[href='#visa']").addClass("selected");
					break;
					case "#mastercard":
					case "mastercard":
						$("[data-card]").hide();
						$("[data-card='mastercard']").show();
						$("section[data-page='products/prepaid-cards/fees'] nav.cards a").removeClass("selected");
						$("section[data-page='products/prepaid-cards/fees'] nav.cards a[href='#mastercard']").addClass("selected");
					break;
					case "#virtual":
					case "virtual":
						$("[data-card]").hide();
						$("[data-card='virtual']").show();
						$("section[data-page='products/prepaid-cards/fees'] nav.cards a").removeClass("selected");
						$("section[data-page='products/prepaid-cards/fees'] nav.cards a[href='#virtual']").addClass("selected");
					break;
				}
			}
			else
				$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card] .fees_navigation [data-card]").show();
			$(window).on('hashchange', function() {
				if (window.location.hash!=null && window.location.hash!="")
				{
					$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card] .fees_navigation").show();
					switch (window.location.hash)
					{
						case "#visa":
						case "visa":
							$("[data-card]").hide();
							$("[data-card='visa']").show();
							$("section[data-page='products/prepaid-cards/fees'] nav.cards a").removeClass("selected");
							$("section[data-page='products/prepaid-cards/fees'] nav.cards a[href='#visa']").addClass("selected");
						break;
						case "#mastercard":
						case "mastercard":
							$("[data-card]").hide();
							$("[data-card='mastercard']").show();
							$("section[data-page='products/prepaid-cards/fees'] nav.cards a").removeClass("selected");
							$("section[data-page='products/prepaid-cards/fees'] nav.cards a[href='#mastercard']").addClass("selected");
						break;
						case "#virtual":
						case "virtual":
							$("[data-card]").hide();
							$("[data-card='virtual']").show();
							$("section[data-page='products/prepaid-cards/fees'] nav.cards a").removeClass("selected");
							$("section[data-page='products/prepaid-cards/fees'] nav.cards a[href='#virtual']").addClass("selected");
						break;
					}
					o = $("section[data-page='products/prepaid-cards/fees'] > div").offset();
					if (o!=null)
						$("body,html").animate({scrollTop: o.top-$(window).height()/2}, 350, "easeOutQuart");
				}
				else
					$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card] .fees_navigation [data-card]").show();
			});
			/*var o = $("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").offset();
			if (!$("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").attr("data-top"))
				$("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").attr("data-top", o.top);
			$(document).scroll(function(){
				if ((parseFloat($("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").attr("data-top"))-$(window).scrollTop())<=50)
				{
					var o = $("section[data-page='products/prepaid-cards/fees'] > div").offset();
					$("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").addClass("fixed");
					if (($(window).scrollTop()+$("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").height()-100)<=$("section[data-page='products/prepaid-cards/fees'] > div").height())
					$("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").css({top:($(window).scrollTop()+50-o.top)});
				}
				else if ($("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").hasClass("fixed"))
				{
					$("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").removeClass("fixed");
					$("section[data-page='products/prepaid-cards/fees'] > div > nav.cards").removeAttr("style");
				}
			});*/

			(window.fees_navigation = function(){
				if ($("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]:visible").size()<=1)
				{
					$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]:visible .fees_navigation").show();
					var o1 = $("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]:visible .fees_navigation [data-card]").offset();
					var o2 = $("#bottom_banner").offset();
					if (o2.top>(o1.top+$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]:visible .fees_navigation [data-card]").height()))
						$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]:visible .fees_navigation").show();
					else
						$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]:visible .fees_navigation").hide();
					return false;
				}
				$("section[data-page='products/prepaid-cards/fees'] > div > div[data-card] .fees_navigation").hide();
				$($("section[data-page='products/prepaid-cards/fees'] > div > div[data-card]").get().reverse()).each(function(){
					var o = $(this).offset();
					if ((o.top-$(window).height()/2)<=$(document).scrollTop() && (o.top+$(this).outerHeight()+150-$(window).height()/2)>=$(document).scrollTop())
					{
						$(this).children(".fees_navigation").show();
						return false;
					}
				});
				return true;
			})();
			$(document).scroll(function(){fees_navigation()});

			// Promo bonus - Fees
			$("#bottom_banner[data-promo='fees'] form").submit(function(e){
				$.post(window.location.pathname+"?ajax=get_bonus", {"email":$(this).find("input[name='email']").val()}, function(r){
					if (r!=null && r.status!=null && r.status=="success")
						$("#bottom_banner[data-promo='fees'] > div").html(r.msg);
					else
						$("#bottom_banner[data-promo='fees'] form input[name='email']").addClass("error");
				});
				e.preventDefault();
				return false;
			});
		}

		// Back to top
		if ($("#back_to_top").size())
		{
			$(document).scroll(function(){
				if ($(document).scrollTop()>=$(window).height() && !$("#back_to_top").hasClass("visible"))
					$("#back_to_top").addClass("visible");
				else if ($(document).scrollTop()<$(window).height() && $("#back_to_top").hasClass("visible"))
					$("#back_to_top").removeClass("visible");
			});
			$("#back_to_top").click(function(){
				$("body,html").animate({scrollTop: 0}, 350, "easeOutQuart");
			});
		}

		// Forex services
		if ($("section[data-page='products/forex-services']").size())
		{
			window.enable_subscribe = false;
			window.subscribe_rates = function()
			{
				$("#forex-subscribe_box .rates > div").remove();
				$(".currencies_table tr[data-rate].selected").each(function(){
					$("#forex-subscribe_box .rates").append("<div data-rate='"+$(this).attr("data-rate")+"'><span>"+$(this).children("td:eq(0)").text()+"</span></div>");
				});
			}

			$(document).on("click","section[data-page='products/forex-services'] tbody tr[data-rate], section[data-page='products/forex-services'] tbody tr[data-rate] *",function(){
				if (!$(this).is("tr") && $("#forex-subscribe_box").size() && window.enable_subscribe==true)
				{
					$(this).closest("tr").toggleClass("selected");
					subscribe_rates();
				}
			});

			$(document).on("click", "#forex-subscribe_box > table td .rates > div[data-rate] > span", function(){
				$("section[data-page='products/forex-services'] tbody tr[data-rate='"+$(this).closest("[data-rate]").attr("data-rate")+"']").removeClass("selected");
				$(this).closest("[data-rate]").remove();
			});

			$("section[data-page='products/forex-services'] .info_box").click(function(){
				if (!$("#forex-subscribe_box").size() && window.enable_subscribe==false)
				{
					window.enable_subscribe = true;
					$.post(window.location.pathname+"?ajax=forex_services", {"step":"texts"}, function(r){
						if (r.status!=null && r.status=="success" && r.data!=null)
						{
							var html = "<div id='forex-subscribe_box'><div>";
								html += "<a class='close'></a>";
								html += "<table><tbody><tr>";
									html += "<td>"+r.data.help+"</td>";
									html += "<td>"+r.data.rates_title+":<div class='rates'></div></td>";
									html += "<td>";
										html += "<form method='post'>";
											html+= r.data.form_title+":<br/>";
											html += "<input type='email' name='email' value='' required='required' />";
											html += "<div class='error'>"+r.data.form_error+"</div>";
											html += "<input type='submit' name='subscribe' value='"+r.data.form_button+"' />";
										html += "</form>";
									html += "</td>";
								html += "</tr></tbody></table>";
							html += "</div></div>";
							$("body").append(html);
							setTimeout(function(){$("#forex-subscribe_box").css({bottom: 0})}, 100);
						}
					});
				}
				var o = $(".currencies_table:eq(0)").offset();
				if (o!=null && o.top!=null)
					$("body,html").animate({scrollTop: o.top-50}, 250, "easeOutQuart");
			});

			$("section[data-page='products/forex-services'] .updated a").click(function(){window.refresh_rates()});

			(window.refresh_rates = function(){
				$.post(window.location.pathname+"?ajax=forex_services", {"step":"rates"}, function(r){
					if (r==null || r=="" || r.status!="success")
						return false;
					$.each(r.data, function(currency, rates){
						var html = "";
						var th = $(".currencies_table[data-currencies='"+currency+"'] table thead th");
						$.each(rates, function(currency2, data){
							html += "<tr data-rate='"+currency.toLowerCase()+"/"+currency2.toLowerCase()+"'><td><strong>"+th.eq(0).text()+":</strong> "+currency+" / "+currency2+"</td><td><strong>"+th.eq(1).text()+":</strong> "+data.buy+"</td><td><strong>"+th.eq(2).text()+":</strong> "+data.sell+"</td><td><strong>"+th.eq(3).text()+":</strong> "+data.middle+"</td><td data-change='"+(data.change!=null && data.change!="" ? (data.change<0 ? "minus" : "plus") : "")+"'><strong>"+th.eq(4).text()+":</strong> "+(data.change!=null && data.change!="" ? (data.change>0 ? "+" : "")+data.change+"%" : "---")+"</td></tr>";
						});
						$(".currencies_table[data-currencies='"+currency+"'] table tbody").html(html);
					});
				});
			})();

			$(document).on("click","#forex-subscribe_box .close",function(){
				$("#forex-subscribe_box").css({"bottom":"-200px"});
				setTimeout(function(){$("#forex-subscribe_box").remove(); window.enable_subscribe = false}, 300);
				$("section[data-page='products/forex-services'] tbody tr.selected").removeClass("selected");
			});

			$(document).on("submit", "#forex-subscribe_box > div > table td form", function(e){
				if ($("section[data-page='products/forex-services'] tbody tr.selected").size()<1)
					return false;
				var email = $("#forex-subscribe_box > div > table td form input[type='email']").val();
				if (email==null || email=="" || !(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i).test(email))
				{
					$("#forex-subscribe_box input[type='text'], #forex-subscribe_box input[type='email']").addClass("error_field");
					$("#forex-subscribe_box > div > table td form .error").show();
					return false;
				}
				var rates = new Array();
				$("section[data-page='products/forex-services'] tbody tr.selected[data-rate]").each(function(){
					rates.push($(this).attr("data-rate"));
				});
				$.post(window.location.pathname+"?ajax=forex_services", {"step":"subscribe", "email": email, "rates": rates}, function(r){
					if (r!=null && r!="" && r.status!=null && r.status=="success")
					{
						window.enable_subscribe = false;
						var html = "<a class='close'></a>";
						html += "<ul>";
							html += "<li class='texts'>";
								html += "<div class='title'>"+r.data.title+"</div>";
								html += "<div class='success'>"+r.data.subscribed+"</div>";
							html += "</li>";
							html += "<li>";
								html += "<div class='envelope'></div>";
							html += "</li>";
						html += "</ul>";
						$("#forex-subscribe_box > div").html(html);
					}
				});
				e.preventDefault();
				return false;
			});

			$("section[data-page='subpage'][data-promo='forex-services'] nav > a.updates").click(function(){
				$("section[data-page='products/forex-services'] .info_box").click();
			});
		}

		// Solutions
		if ($("section[data-page^='solutions/']").size())
		{
			$("section.services[data-page^='solutions/'] ul.list > li figure a[data-service]").click(function(){
				$("div[data-service]").hide();
				$("div[data-service='"+$(this).attr("data-service")+"']").show();
				var o = $("div[data-service='"+$(this).attr("data-service")+"']").offset();
				if (o!=null)
					$("body,html").animate({scrollTop: (o.top-$(window).height()/6)}, 350, "easeOutQuart");
			});

			// Hide paragraphs
			$.post(window.location.pathname+"?ajax=translations", {}, function(r){
				if (r==null || r=="" || r.status!="success")
					return false;
				$("section.features[data-page^='solutions/'] ul > li").each(function(k,v){
					$(this).attr("data-order", k)
					if ($(this).find("p").size()>1)
					{
						$(this).find("p:gt(0)").hide();
						$(this).find("p:eq(0)").append("<span class='more'> <a>"+r.translations.more+" <small>&gt;&gt;&gt;</small></a></span>");
						$(this).find("p:last").append("<span class='less'> <a><small>&lt;&lt;&lt;</small> "+r.translations.less+"</a></span>");
					}
				});
			});
			// More
			$(document).on("click","section[data-page^='solutions/'].features ul > li span.more",function(){
				/*var li = $(this).closest("li[data-order]");
				var o = li.parent("ul").offset();
				if (o!=null)
					$("body,html").animate({scrollTop: (o.top-$(window).height()/6)}, 750, "easeOutQuart");
				li.css({"display":"block", "width": "100%"});
				li.find("p:gt(0)").show();
				li.find("p:eq(0)").hide();
				var h = li.outerHeight(true);
				li.find("p:gt(0)").hide();
				li.find("p:eq(0)").show();
				li.removeAttr("style");

				if (!$("section[data-page^='solutions/'].features ul > li:eq(0) p:first-of-type").is(":visible"))
				{
					$("section[data-page^='solutions/'].features ul > li:eq(0)").fadeTo(90, 0.001, function(){
						$(this).parent("ul").css({paddingTop: $(this).outerHeight(true)});
						$(this).removeAttr("style");
						$(this).find("p:gt(0)").hide();
						$(this).find("p:eq(0)").show();
						var i = parseFloat($(this).attr("data-order"));
						if ($("section[data-page^='solutions/'].features ul > li[data-order='"+(i+1)+"']").size())
							$("section[data-page^='solutions/'].features ul > li[data-order='"+(i+1)+"']").before($(this).clone());
						else
							$("section[data-page^='solutions/'].features ul").append($(this).clone());
						$(this).remove();

						li.parent("ul").animate({paddingTop: h}, 450);
						li.fadeTo(100, 0.001, function(){
							$(this).css({"overflow":"hidden", width: $(this).outerWidth(), height: $(this).outerHeight()});
							$(this).animate({width: 0, margin: 0, padding: 0}, 360, function(){
								$(this).removeAttr("style");
								$(this).css({"display": "block", width: "100%", opacity: 0.001});
								$(this).find("p:gt(0)").show();
								$(this).find("p:eq(0)").hide();
								$(this).parent("ul").prepend($(this).clone());
								$(this).parent("ul").css({paddingTop: 0});
								$(this).parent("ul").children("li:eq(0)").fadeTo(150, 1);
								$(this).remove();
							});
						});
					});
				}
				else
				{
					li.parent("ul").animate({paddingTop: h}, 450);
					li.fadeTo(100, 0.001, function(){
						$(this).css({"overflow":"hidden", width: $(this).outerWidth(), height: $(this).outerHeight()});
						$(this).animate({width: 0, margin: 0, padding: 0}, 360, function(){
							$(this).removeAttr("style");
							$(this).css({"display": "block", width: "100%", opacity: 0.001});
							$(this).find("p:gt(0)").show();
							$(this).find("p:eq(0)").hide();
							$(this).parent("ul").prepend($(this).clone());
							$(this).parent("ul").css({paddingTop: 0});
							$(this).parent("ul").children("li:eq(0)").fadeTo(150, 1);
							$(this).remove();
						});
					});
				}*/

				var li = $(this).closest("li[data-order]");
				li.find("p:gt(0)").show();
				$(this).hide();
				var h = li.height();
				li.find("p:gt(0)").hide();
				li.find("p:eq(0)").show();
				$(this).show();
				li.removeAttr("style");

				li.animate({height: h}, 170+(h/350)*200, function(){
					$(this).removeAttr("style");
					$(this).find("p:gt(0)").show();
					$(this).addClass("opened");
					$(this).find(".more").hide();
				});
			});
			// Less
			$(document).on("click","section[data-page^='solutions/'].features ul > li span.less",function(){
				/*var li = $(this).closest("li[data-order]");
				var h = li.outerHeight(true);
				li.css({minHeight: 0});
				li.fadeTo(100, 0.001, function(){
					$(this).parent("ul").css({paddingTop: h});
					$(this).parent("ul").animate({paddingTop: 0}, 500);
					$(this).css({"overflow": "hidden", width: 0, height: 0, margin: 0, padding: 0});
					var i = parseFloat($(this).attr("data-order"));
					if ($("section[data-page^='solutions/'].features ul > li[data-order='"+(i+1)+"']").size())
						$("section[data-page^='solutions/'].features ul > li[data-order='"+(i+1)+"']").before($(this).clone());
					else
						$("section[data-page^='solutions/'].features ul").append($(this).clone());
					$(this).remove();
					var li = $("section[data-page^='solutions/'].features ul > li[data-order='"+i+"']");
					li.find("p:gt(0)").hide();
					li.find("p:eq(0)").show();
					li.css({"display": "inline-block"});
					li.animate({width: "50%"}, 350, function(){
						$(this).removeAttr("style");
					});
				});*/
				
				var li = $(this).closest("li[data-order]");
				li.find("p:gt(0)").hide();
				var h = li.height();
				li.find("p:gt(0)").show();
				li.removeAttr("style");
				li.removeClass("opened");

				li.css({"overflow":"hidden"});
				li.animate({height: h}, 170+(h/350)*200, function(){
					$(this).removeAttr("style");
					$(this).find("p:gt(0)").hide();
					$(this).find(".more").show();
				});
			});
		}

		// Cash Transfers
		if ($("section[data-page='products/cash-transfers']").size())
		{
			$("section[data-page='products/cash-transfers'] .way-switch a[data-way]:eq(0)").addClass("curr");
			$(document).on("click","section[data-page='products/cash-transfers'] .client-selector li[data-client]:not(.curr)", function(){
				$("section[data-page='products/cash-transfers'] .client-selector li[data-client].curr").removeClass("curr");
				$(this).addClass("curr");
				$("section[data-page='products/cash-transfers'] .way-switch a[data-way].curr").removeClass("curr");
				$("section[data-page='products/cash-transfers'] .way-switch a[data-way]:eq(0)").addClass("curr");
				$("section[data-page='products/cash-transfers'] div[data-client]").hide();
				$("section[data-page='products/cash-transfers'] div[data-client='"+$(this).attr("data-client")+"']").show();
				$("[data-client]").removeClass("path1").removeClass("path2").removeClass("path3");
				var o = $("section[data-page='products/cash-transfers'] div[data-client='"+$(this).attr("data-client")+"']").offset();
				if (o!=null)
					$("body,html").animate({scrollTop: (o.top-$(window).height()/6)}, 350, "easeOutQuart");
			});

			$(document).on("click","section[data-page='products/cash-transfers'] .way-switch a[data-way]",function(){
				$("section[data-page='products/cash-transfers'] .way-switch a[data-way].curr").removeClass("curr");
				$(this).addClass("curr");
				$("[data-client]").removeClass("path1").removeClass("path2").removeClass("path3");
				$("[data-client]:visible").addClass("path"+($(this).index("section[data-page='products/cash-transfers'] .way-switch a[data-way]")+1));
				var o = $("section[data-page='products/cash-transfers'] div[data-client]:visible").offset();
				if (o!=null)
					$("body,html").animate({scrollTop: (o.top-$(window).height()/6)}, 350, "easeOutQuart");
			});
		}

		// Cash transfers
		if ($("section[data-page='subpage'][data-promo='cash-transfers']").size())
		{
			$("section[data-page='subpage'][data-promo='cash-transfers'] form")[0].reset();

			// Countries
			$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='country']").closest("div.fie").append("<span class='loading'></span>");
			$.post(window.location.pathname+"?ajax=money_transfer", {"step":"countries"}, function(r){
				if (r==null || r=="" || r.status!="success")
					return false;
				$.each(r.data, function(k, country){
					$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='country']").append("<option value='"+country.ID+"'>"+country.Description+"</option>");
				});
				$("section[data-page='subpage'][data-promo='cash-transfers'] div.fie span.loading").remove();
			});

			// Cities
			$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='country']").change(function(){
				$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='city']").children("option:not([disabled='disabled'])").remove();
				$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='amount']").val('');
				$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='currency']").children("option").remove();
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission > figure").show();
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission .result, section[data-page='subpage'][data-promo='cash-transfers'] form > div.branches").hide();
				$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr:not(.placeholder)").remove();
				$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr.placeholder").show();
				$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='city']").closest("div.fie").append("<span class='loading'></span>");
				$.post(window.location.pathname+"?ajax=money_transfer", {"step":"cities","country":$(this).children("option:selected").val()}, function(r){
					if (r==null || r=="" || r.status!="success")
						return false;
					$.each(r.data.cities, function(k, city){
						$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='city']").append("<option value='"+city.ID+"'>"+city.Description+"</option>");
					});
					$.each(r.data.currencies, function(k, currency){
						$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='currency']").append("<option value='"+currency.Code+"'>"+currency.Code+"</option>");
					});
					$("section[data-page='subpage'][data-promo='cash-transfers'] div.fie span.loading").remove();
				});
			});

			// Change city or currency
			$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='city'], section[data-page='subpage'][data-promo='cash-transfers'] select[name='currency']").change(function(){
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission > figure").show();
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission .result, section[data-page='subpage'][data-promo='cash-transfers'] form > div.branches").hide();
				$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr:not(.placeholder)").remove();
				$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr.placeholder").show();
			});

			// Branches
			$("section[data-page='subpage'][data-promo='cash-transfers'] button.calc").click(function(){
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission > figure").show();
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission .result, section[data-page='subpage'][data-promo='cash-transfers'] form > div.branches").hide();
				$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr:not(.placeholder)").remove();
				$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr.placeholder").show();
				$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table").closest("div.fie").append("<span class='loading'></span>");
				$.post(window.location.pathname+"?ajax=money_transfer", {"step":"branches","city":parseInt($("section[data-page='subpage'][data-promo='cash-transfers'] select[name='city'] option:selected").val()),"currency":$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='currency'] option:selected").val(),"amount":parseFloat($("section[data-page='subpage'][data-promo='cash-transfers'] input[name='amount']").val())}, function(r){
					$("section[data-page='subpage'][data-promo='cash-transfers'] div.fie span.loading").remove();
					if (r==null || r=="" || r.status!="success")
						return false;
					if (r.data!=null)
					{
						var branches = new Object();
						$.each(r.data, function(k,v){
							if (branches[v.PSCODE]==null)
								branches[v.PSCODE] = {"branches": 0, "commission": (100*parseFloat(v.ApproximateComission)/parseFloat($("section[data-page='subpage'][data-promo='cash-transfers'] input[name='amount']").val())), "fee": parseFloat(v.ApproximateComission), "PSCODE_formated": v.PSCODE_formated};
							branches[v.PSCODE].branches++;
							if (branches[v.PSCODE].commission>parseFloat(v.ApproximateComission))
								branches[v.PSCODE].commission = parseFloat(v.ApproximateComission);
						});
						systems = Object.keys(branches).sort(function(a,b){return branches[a].commission-branches[b].commission});
						$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr.placeholder").hide();
						$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody").removeClass("one-branch");
						if (systems.length<=1)
							$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody").addClass("one-branch");
						$.each(systems, function(k,v){
							$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody").append("<tr data-commission='"+branches[v].commission+"' data-fee='"+branches[v].fee+"' data-branch='"+v+"'"+(k==0 ? " class='selected'" : "")+"><td>"+branches[v].PSCODE_formated+"</td><td>"+branches[v].branches+"</td><td>% "+branches[v].commission.toFixed(1)+"</td></tr>");
						});
						branch_fee(branches[systems[0]].fee);
					}
					else if (r.error!=null)
						alert(r.error);
				});
			});

			// Choose different system
			$(document).on("click","section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr:not(.placeholder)", function(){
				var tbody = $(this).parent("tbody");
				if (!tbody.hasClass("opened"))
					tbody.addClass("opened");
				else
				{
					tbody.children(".selected").removeClass("selected");
					$(this).addClass("selected");
					tbody.removeClass("opened");
					branch_fee(parseFloat($(this).attr("data-fee")));
				}
			});
			function branch_fee(fee)
			{
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission > figure").hide();
				$("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission .result").show();
				var online = $("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission .result ul li:first-child");
				var offline = $("section[data-page='subpage'][data-promo='cash-transfers'] ul .final_commission .result ul li:last-child");
				var symbol = $("section[data-page='subpage'][data-promo='cash-transfers'] select[name='currency'] option:selected").val();
				switch (symbol)
				{
					case "USD":
						symbol = "\$ {0}";
					break;
					case "GBP":
						symbol = "£ {0}";
					break;
					case "EUR":
						symbol = "{0} €";
					break;
					case "CZK":
						symbol = "{0} Kč";
					break;
					default:
						symbol = "{0} "+symbol;
					break;
				}
				var amount = parseFloat($("section[data-page='subpage'][data-promo='cash-transfers'] input[name='amount']").val());
				online.find(".amount").html(symbol.format((parseFloat((parseFloat(fee)+amount).toFixed(2))+"").replace(/(\.\d+)$/, "<small>$1</small>")));
				var plus = amount*.01;
				offline.find(".amount").html(symbol.format((parseFloat((parseFloat(fee)+plus+amount).toFixed(2))+"").replace(/(\.\d+)$/, "<small>$1</small>")));

				var branches = $("section[data-page='subpage'][data-promo='cash-transfers'] form > div.branches");
				branches.children("a").attr("href", branches.children("a").attr("href").replace(/\?.*$/, "")+"?city="+parseInt($("section[data-page='subpage'][data-promo='cash-transfers'] select[name='city'] option:selected").val())+"&amount="+parseFloat($("section[data-page='subpage'][data-promo='cash-transfers'] input[name='amount']").val())+"&currency="+$("section[data-page='subpage'][data-promo='cash-transfers'] select[name='currency'] option:selected").val()/*+"&branch="+$("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie table tbody tr.selected").attr("data-branch")*/);
				branches.children("a").children(".city").text($("section[data-page='subpage'][data-promo='cash-transfers'] form div.fie select[name='city'] option:selected").text());
				branches.show();
			}
		}
		if ($("section[data-page='products/cash-transfers/transfer-branches']").size())
		{
			function get_query(){
				var url = location.href;
				var qs = url.substring(url.indexOf('?') + 1).split('&');
				for(var i=0, result={}; i<qs.length; i++)
				{
					qs[i] = qs[i].split('=');
					result[qs[i][0]] = qs[i][1];
				}
				return result;
			}

			var get = get_query();
			if (get['city']==null || get['amount']==null || get['currency']==null)
				window.location = window.location.href.replace(/\/[\w-]+\/$/, "/");

			$.post(window.location.pathname+"?ajax=money_transfer", {"step":"branches","city":parseInt(get['city']),"currency":get['currency'],"amount":parseFloat(get['amount'])}, function(r){
				if (r==null || r=="" || r.status!="success")
					return false;
				if (r.data!=null)
				{
					var branches = new Array();
					$.each(r.data, function(k,v){
						if (get['branch']==null || get['branch']==v.PSCODE)
							branches.push(v);
					});
					branches = branches.sort(function(a,b){return a.ApproximateComission-b.ApproximateComission});
					var table = $("section[data-page='products/cash-transfers/transfer-branches'] table tbody");
					table.find("tr").remove();
					$.each(branches, function(k, v){
						table.append("<tr><td><h3>"+v.Name+"</h3>"+v.Address+"<br/>"+v.Phone+"</td><td>"+v.WorkingDays+(v.WorkingDays!="" ? "<br/>" : "")+v.WorkingHours+"</td><td>"+v.Currencies+"</td></tr>");
					});
				}
				else if (r.error!=null)
					alert(r.error);
			});
		}

		// Multi-Currency Account
		if ($("section[data-page='subpage'][data-promo='multi-currency-account']").size())
		{
			$("section[data-page='subpage'][data-promo='multi-currency-account'] form")[0].reset();
			$.post(window.location.pathname+"?ajax=multi_currency_transfers", {}, function(r){
				if (r==null || r=="" || r.status==null || r.status!="success")
					return false;
				$.each(r.currencies, function(k,v){
					if (r.rates[v]!=null && r.rates[v].buy!=null && r.rates[v].sell!=null)
						$("select[name='currency1'], select[name='currency2']").append("<option value='"+v+"'>"+v+"</option>");
				});
				$.currency_rates = r.rates;
			});
			$(document).on("input keyup", "section[data-page='subpage'][data-promo='multi-currency-account'] input[name='amount1']", function(){$.update_rates(true)});
			$(document).on("input keyup", "section[data-page='subpage'][data-promo='multi-currency-account'] input[name='amount2']", function(){$.update_rates(false)});
			$(document).on("change", "section[data-page='subpage'][data-promo='multi-currency-account'] select", function(){
				$("section[data-page='subpage'][data-promo='multi-currency-account'] input[name^='amount']").val('');
				if ($("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()!="" && $("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val()!="")
				{
					var rates = $.get_rates();
					$("section[data-page='subpage'][data-promo='multi-currency-account'] form div.fie table tbody").html("<tr><td>"+$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()+"/"+$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val()+"</td><td>"+(parseFloat(rates.buy)).toFixed(2)+"</td><td>"+(parseFloat(rates.sell)).toFixed(2)+"</td></tr>");
				}
			});
			$.update_rates = function(buy)
			{
				if ($("select[name='currency1'] option:selected").val()=="" || $("select[name='currency2'] option:selected").val()=="")
					return false;
				if (buy===true)
				{
					i = 1;
					j = 2;
				}
				else
				{
					i = 2;
					j = 1;
				}
				var from = {"currency": $("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency"+i+"'] option:selected").val(), "amount": parseFloat($("section[data-page='subpage'][data-promo='multi-currency-account'] input[name='amount"+i+"']").val()!="" ? $("section[data-page='subpage'][data-promo='multi-currency-account'] input[name='amount"+i+"']").val() : 0)};
				var to = {"currency": $("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency"+j+"'] option:selected").val(), "amount": 0};
				if ($("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()==$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val())
				{
					$("section[data-page='subpage'][data-promo='multi-currency-account'] input[name='amount"+j+"']").val(from.amount.toFixed(2));
					return false;
				}
				var rates = $.get_rates();
				if (buy===true)
					to.amount = (from.amount*rates.sell);
				else
					to.amount = (from.amount/rates.buy);
				$("section[data-page='subpage'][data-promo='multi-currency-account'] input[name='amount"+j+"']").val(to.amount.toFixed(2));
				return true;
			}
			$.get_rates = function()
			{
				if ($("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()!=$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val())
					{
					var rates = {sell: 0, buy: 0};
					if ($("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()=="GBP")
					{
						rates.buy = $.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val()].buy;
						rates.sell = $.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val()].sell;
					}
					else if ($("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val()=="GBP")
					{
						rates.buy = 1/$.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()].sell;
						rates.sell = 1/$.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()].buy;
					}
					else
					{
						rates.buy = 1/($.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()].sell/$.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val()].buy);
						rates.sell = 1/($.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency1'] option:selected").val()].buy/$.currency_rates[$("section[data-page='subpage'][data-promo='multi-currency-account'] select[name='currency2'] option:selected").val()].sell);
					}
				}
				else
					var rates = {buy: 1, sell: 1};
				return rates;
			}
		}
	});
})(jQuery);