//Author Pierre-Alexis Barras <Pyxsys>

//disable submission button on initial load
var wButton = document.getElementById("submitbutton");
wButton.disabled = true;

//If there is an active cooldwn, triggr=ered by redirect, display Countdown
var wTargetTime = document.getElementById("targetTime");
if(typeof(wTargetTime) != 'undefined' && wTargetTime != null){
	Countdown(wTargetTime.value);
}

// Adds an element to the document
function AddElement(iParentId, iElementTag, iElementId, iClassName, iHTML) {
	
    var p = document.getElementById(iParentId);
    var wElement = document.createElement(iElementTag);
    wElement.setAttribute('id', iElementId);
	wElement.setAttribute('class', iClassName)
    wElement.innerHTML = iHTML;
    p.appendChild(wElement);
	
	return true;
}

// Modifies an element's contents
function ModifyElement(iElementId, iDisplay, iHTML){
	//check that the element exists. return false if it doesnt;
	var wElement = document.getElementById(iElementId);
	if(typeof(wElement) != 'undefined' && wElement != null){
		console.log("Modified: " + iElementId + ": " + iHTML);
		wElement.innerHTML = iHTML;
		wElement.style.display = iDisplay;
		return true;
	}
	else {return false;}
}

//validates the upload
function ValidateUpload(){
	
	var wValidFile = ValidateFile(); //returns true if file is ok or not there
	var wValidText = ValidateText();	//returns true if there is text that doesnt start with whitespace
	
	//removes empty submission error
	var wElement = document.getElementById("badPostWarning");
	if(typeof(wElement) != 'undefined' && wElement != null){
		ModifyElement("badPostWarning", "none", "no error");
	}
	
	
	console.log("Submission Status");
	console.log(" -file status: " + wValidFile);
	console.log(" -text status: " + wValidText);
	
	//enable submission if: file is good, text is good, or both are good
	wButton.disabled = true; //default disabled
	if(wValidFile == true && wValidText == "isempty"){ wButton.disabled = false; return true;}
	if(wValidFile == "isempty" && wValidText){ wButton.disabled = false; return true;}
	if(wValidFile == true && wValidText == true){ wButton.disabled = false; return true;}
}

function ValidatePFP(){
	var wValidFile = ValidateFile(65000); //returns true if file is ok or not there
	
	//removes empty submission error
	var element = document.getElementById("badPostWarning");
	if(typeof(element) != 'undefined' && element != null){
		ModifyElement("badPostWarning", "none", "no error");
	}
	
	
	console.log("Submission Status");
	console.log(" -file status: " + wValidFile);
	
	//enable submission if: file is good, text is good, or both are good
	wButton.disabled = true; //default disabled
	if(wValidFile == true){ wButton.disabled = false; return true;}
	
}

//Validates the file and throws warnings appropriately
//returns false on valid file or no file (don't quite understand why js does this)
function ValidateFile(limit) {
        var wImgFile = document.getElementById('fileinput').files[0];
		if(wImgFile == null){ModifyElement("fl", "block", "Upload an image"); return "isempty";} //if no file -> return "isempty";
		
		var cRegex = new RegExp("(.*?)\.(gif|jpg|jpeg|png|swf|psd|bmp|jpc|jp2|jpx|jb2|swc|iff|wbmp|xbm|ico|webp)$");
		var oPasscount = 0;
		
		//truncate filename for display
		var wName = (wImgFile.name.length < 30) ? wImgFile.name : wImgFile.name.substring(0,20) + "..." + wImgFile.name.substring(wImgFile.name.lastIndexOf(".")-3,wImgFile.name.length);
		//modify label to show the selected file
		ModifyElement("fl", "block", wName);
		
		var wSizeWarn = document.getElementById("sizeWarning");
		var wTypeWarn = document.getElementById("typeWarning");
		
		//Size warning - file must be greater than 12b
		if(wImgFile.size < 12){
			if(typeof(wSizeWarn) != 'undefined' && wSizeWarn != null){
				ModifyElement("sizeWarning", "block", "* File is smaller than 12b: \[" + wName + "\] is " + wImgFile.size + "b in size.");
			} else{
				AddElement("warnings","p","sizeWarning","upload_warning","* File is smaller than 12b: \[" + wName + "\] is " + wImgFile.size + "b in size.");
			}
		}
		else { 
			ModifyElement("sizeWarning", "none", "no error");
			oPasscount += 1;
		}
		
		//Size warning - file must be less than limit if there is one
		if(limit!=null && wImgFile.size > limit){
			oPasscount-=1; //prevents error overwriting
			
			if(typeof(wSizeWarn) != 'undefined' && wSizeWarn != null){
				ModifyElement("sizeWarning", "block", "* File is greater than " + Math.floor(limit/1000) + "Kb: \[" + wName + "\] is " + Math.ceil(wImgFile.size/1000) + "Kb in size.");
			} else{
				AddElement("warnings","p","sizeWarning","upload_warning","* File is greater than " + Math.floor(limit/1000) + "Kb: \[" + wName + "\] is " +Math.ceil(wImgFile.size/1000) + "b in size.");
			}
		}
		
		//Type warning - file must be an image
        if (!(cRegex.test(wImgFile.name.toLowerCase()))) {
			if(typeof(wTypeWarn) != 'undefined' && wTypeWarn != null){
				ModifyElement("typeWarning", "block", "* File \[" + wName + "\] is not a valid image type (.jpeg, .png, .gif)");
			} else{
				AddElement("warnings","p","typeWarning","upload_warning","* File \[" + wName + "\] is not a valid image type (.jpeg, .png, .gif)");
			}
        }
		else { 
			ModifyElement("typeWarning", "none", "no error");
			oPasscount += 1;
		}

		return (oPasscount == 2);
}

//retuns true if there is text content that doesnt start with whitespace
//otherwise returns false or "isempty" if there is no text
function ValidateText() {
	var wText = document.getElementById("textinput").value;
	var cRegex = new RegExp("^\\S+");
	if(wText) {
		return cRegex.test(wText);
	}
	else {return "isempty"}	
}

function Countdown(iTarget) { //source:: w3schools
	
	// Update the count down every second
	var x = setInterval(function() {

		// Get today's date and time
		var wNow = new Date().getTime();
    
		// Find the distance between now and the count down date
		var wDistance = iTarget - wNow;
    
		// Time calculations for days, hours, minutes and seconds
		var wHours = Math.floor((wDistance % (1000 * 3600 * 24)) / (1000 * 3600));
		var wMinutes = Math.floor((wDistance % (1000 * 3600)) / (1000 * 60));
		var wSeconds = Math.floor((wDistance % (1000 * 60)) / 1000);
		
		//adjust string to be dynamic and remove unecessary information
		var oOutput = "";
		if(wHours > 0){oOutput += wHours + "h ";}
		if(wMinutes > 0){oOutput += wMinutes + "m ";}
		if(wSeconds >= 0){oOutput += wSeconds + "s ";}
    
		// Output the result in the element
		document.getElementById("timeout").innerHTML = oOutput;
    
		// If the count down is over, write some text 
		if (wDistance < 0) {
			clearInterval(x);
			ModifyElement("timeoutWarning", "block", "* You are eligible to post again.")
		}
		
	}, 1000);
}