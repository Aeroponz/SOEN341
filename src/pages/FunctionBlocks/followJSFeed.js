function changeText(followId) {
	var follow = document.getElementById(followId);
	if(follow.value == 'Follow')
	{
		follow.value = 'UnFollow';
	}
	else{
		follow.value = 'Follow';
	}
	//refresh after dealy to update other posts button
	setTimeout(location.reload.bind(location), 50)
	return true;
};