//Author Pierre-Alexis Barras <Pyxsys>

//disable submission button on initial load
var button = document.getElementById("submitbutton");
button.disabled = true;

// Adds an element to the document
function addElement(parentId, elementTag, elementId, class_name, html) {
	
    var p = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
	newElement.setAttribute('class', class_name)
    newElement.innerHTML = html;
    p.appendChild(newElement);
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
		if(imgfile == null){return "isempty";} //if no file -> return "isempty";
		
		var regex = new RegExp("(.*?)\.(gif|jpg|jpeg|png|swf|psd|bmp|jpc|jp2|jpx|jb2|swc|iff|wbmp|xbm|ico|webp)$");
		var passcount = 0;
		
		//Size warning - file must be greater than 12b
		if(imgfile.size < 12){
			var element = document.getElementById("sizeWarning");
			
			if(typeof(element) != 'undefined' && element != null){
				modifyElement("sizeWarning", "block", "File is smaller than 12b: \[" + imgfile.name.toLowerCase() + "\] is " + imgfile.size + "b in size.");
			} else{
				addElement("warnings","p","sizeWarning","upload_warning","File is smaller than 12b: \[" + imgfile.name.toLowerCase() + "\] is " + imgfile.size + "b in size.");
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
				modifyElement("typeWarning", "block", "File \[" + imgfile.name.toLowerCase() + "\] is not a valid image type.");
			} else{
				addElement("warnings","p","typeWarning","upload_warning","File \[" + imgfile.name.toLowerCase() + "\] is not a valid image type.");
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