try { 
objects = document.getElementsByTagName("embed"); 
for (var i = 0; i < objects.length; i++) 
{ 
    objects[i].outerHTML = objects[i].outerHTML; 
} 

} catch (e) {} 

	/*
try { 
objects = document.getElementsByTagName("object"); 
for (var i = 0; i < objects.length; i++) 
{ 
    objects[i].outerHTML = objects[i].outerHTML; 
} 

} catch (e) {} 
*/