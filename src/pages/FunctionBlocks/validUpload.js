//Author Pierre-Alexis Barras <Pyxsys>

//disable submission button on initial load
var button = document.getElementById("submitbutton");
button.disabled = true;

//If there is an active cooldwn, triggr=ered by redirect, display countdown
var targetTime = document.getElementById("targetTime");
if(typeof(targetTime) != 'undefined' && targetTime != null){
	countdown(targetTime.value);
}

// Adds an element to the document
function addElement(parentId, elementTag, elementId, class_name, html) {
	
    var p = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
	newElement.setAttribute('class', class_name)
    newElement.innerHTML = html;
    p.appendChild(newElement);
	
	return true;
}

// Modifies an element's contents
function modifyElement(elementId, display, html){
	//check that the element exists. return false if it doesnt;
	var element = document.getElementById(elementId);
	if(typeof(element) != 'undefined' && element != null){
		console.log("Modified: " + elementId + ": " + html);
		element.innerHTML = html;
		element.style.display = display;
		return true;
	}
	else {return false;}
}

//validates the upload
function validateUpload(){
	
	var validFile = validateFile(); //returns true if file is ok or not there
	var validText = validateText();	//returns true if there is text that doesnt start with whitespace
	
	//removes empty submission error
	var element = document.getElementById("badPostWarning");
	if(typeof(element) != 'undefined' && element != null){
		modifyElement("badPostWarning", "none", "no error");
	}
	
	
	console.log("Submission Status");
	console.log(" -file status: " + validFile);
	console.log(" -text status: " + validText);
	
	//enable submission if: file is good, text is good, or both are good
	button.disabled = true; //default disabled
	if(validFile == true && validText == "isempty"){ button.disabled = false; return true;}
	if(validFile == "isempty" && validText){ button.disabled = false; return true;}
	if(validFile == true && validText == true){ button.disabled = false; return true;}
}

//Validates the file and throws warnings appropriately
//returns false on valid file or no file (don't quite understand why js does this)
function validateFile() {
        var imgfile = document.getElementById('fileinput').files[0];
		if(imgfile == null){modifyElement("fl", "block", "Upload an image"); return "isempty";} //if no file -> return "isempty";
		
		var regex = new RegExp("(.*?)\.(gif|jpg|jpeg|png|swf|psd|bmp|jpc|jp2|jpx|jb2|swc|iff|wbmp|xbm|ico|webp)$");
		var passcount = 0;
		
		//truncate filename for display
		var name = (imgfile.name.length < 30) ? imgfile.name : imgfile.name.substring(0,20) + "..." + imgfile.name.substring(imgfile.name.lastIndexOf(".")-3,imgfile.name.length);
		//modify label to show the selected file
		modifyElement("fl", "block", name);
		
		//Size warning - file must be greater than 12b
		if(imgfile.size < 12){
			var element = document.getElementById("sizeWarning");
			
			if(typeof(element) != 'undefined' && element != null){
				modifyElement("sizeWarning", "block", "* File is smaller than 12b: \[" + name + "\] is " + imgfile.size + "b in size.");
			} else{
				addElement("warnings","p","sizeWarning","upload_warning","* File is smaller than 12b: \[" + name + "\] is " + imgfile.size + "b in size.");
			}
		}
		else { 
			modifyElement("sizeWarning", "none", "no error");
			passcount += 1;
		}
		
		//Type warning - file must be an image
        if (!(regex.test(imgfile.name.toLowerCase()))) {
            var element = document.getElementById("typeWarning");
			
			if(typeof(element) != 'undefined' && element != null){
				modifyElement("typeWarning", "block", "* File \[" + name + "\] is not a valid image type (.jpeg, .png, .gif)");
			} else{
				addElement("warnings","p","typeWarning","upload_warning","* File \[" + name + "\] is not a valid image type (.jpeg, .png, .gif)");
			}
        }
		else { 
			modifyElement("typeWarning", "none", "no error");
			passcount += 1;
		}

		return (passcount == 2);
}

//retuns true if there is text content that doesnt start with whitespace
//otherwise returns false or "isempty" if there is no text
function validateText() {
	var text = document.getElementById("textinput").value;
	var regex = new RegExp("^\\S+");
	if(text) {
		return regex.test(text);
	}
	else {return "isempty"}	
}

function countdown(target) { //source:: w3schools
	
	// Update the count down every second
	var x = setInterval(function() {

		// Get today's date and time
		var now = new Date().getTime();
    
		// Find the distance between now and the count down date
		var distance = target - now;
    
		// Time calculations for days, hours, minutes and seconds
		var hours = Math.floor((distance % (1000 * 3600 * 24)) / (1000 * 3600));
		var minutes = Math.floor((distance % (1000 * 3600)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		//adjust string to be dynamic and remove unecessary information
		var output = "";
		if(hours > 0){output += hours + "h ";}
		if(minutes > 0){output += minutes + "m ";}
		if(seconds >= 0){output += seconds + "s ";}
    
		// Output the result in the element
		document.getElementById("timeout").innerHTML = output;
    
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(x);
			modifyElement("timeoutWarning", "block", "* You are eligible to post again.")
		}
		
	}, 1000);
}