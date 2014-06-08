//function setColor()
//{
	var r = Math.random();

if (r<.25)
{
	//lemon
	//alert("less than .25 - r: "+r);
	bgColor = "#E4E421";
	linkColor = "#B1B11A";
	vlinkColor = "#65652D";
	headerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/header_lemon.gif)";
	footerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/footer_lemon.gif)";
}
else if (r>=.25 && r<.5)
{
	//tomato
	//alert("greater than .25 but less than .5 - r: "+r);
	bgColor = "#AE123C";
	linkColor = "#AE123C";
	vlinkColor = "#7A0D2A";
	headerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/header_tomato.gif)";
	footerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/footer_tomato.gif)";
}
else if (r>=.5 && r<.75)
{
	//eggplant
	//alert("greater than .5 but less than .75 - r: "+r);
	bgColor = "#582261";
	linkColor = "#582261";
	vlinkColor = "#74507B";
	headerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/header_eggplant.gif)";
	footerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/footer_eggplant.gif)";
}
else
{
	//carrot
	//alert("greater than .75 but less than .1 - r: "+r);
	bgColor = "#EB6F24";
	linkColor = "#EB6F24";
	vlinkColor = "#6B4630";
	headerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/header_carrot.gif)";
	footerImage = "url(http://www.vegetarianized.dreamhosters.com/old_media/footer_carrot.gif)";
}

$(document).ready(function() {
	$("body").css("background-color", bgColor);
	$("#header-wrapper").css("background", headerImage);
	$("#footer-wrapper").css("background", footerImage); 
	$("a:link").css("color",linkColor);
	$("a:visited").css("color",vlinkColor);
 });

//document.getElementsByTagName("body")[0].style.backgroundColor = bgColor;
//document.getElementById("header-wrapper").style.backgroundImage = headerImage;
//document.getElementById("footer-wrapper").style.backgroundImage = footerImage;

//var test = document.getElementsByTagName("a")[0].style;
//for (x in test)
	//alert(x+" "+test[x]);

//var theStyleSheets = document.styleSheets;

//document.body.link = linkColor;
//document.body.vLink = vlinkColor;


/*for (p=0; p<theStyleSheets.length;p++)
{
	//alert(document.styleSheets[p]);
	
	if (document.styleSheets[p].cssRules) {
		var theCssRules = document.styleSheets[p].cssRules;
	} else if (document.styleSheets[p].rules) {
		var theCssRules = document.styleSheets[p].rules;
	}
	
	
	
	if (theCssRules[0] != null)
	{
		var theFirstRule = theCssRules[0];
		//alert(theFirstRule.slice(0,4));
		if (theFirstRule.selectorText == "body")
		{
			var ourSheet = theCssRules;
		
			for (i=0; i<ourSheet.length;i++)
			{
				if (ourSheet[i].selectorText == "a:link")
				{
					theStyleToMod = ourSheet[i];
					theStyleToMod.style.color = linkColor;
					//for (x in theStyleToMod)
//						alert(x+" "+theStyleToMod[x]);
				}
				else if (ourSheet[i].selectorText == "a:visited")
				{
					theStyleToMod = ourSheet[i];
					theStyleToMod.style.color = vlinkColor;
					//for (x in theStyleToMod)
//						alert(x+" "+theStyleToMod[x]);
				}
			}
		}
	}
}*/
//}
