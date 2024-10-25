function checkClassExists(className) {
    // Check if class exists in the document
    const elements = document.getElementsByClassName(className.substring(1));
    
    const colorControl = document.getElementById('background_color_for_section_control');

    if (elements.length > 0) {
        // If class exists, show the color picker
        colorControl.style.display = 'block'; // Show the color picker
    } else {
        // If class does not exist, hide the color picker
        colorControl.style.display = 'none'; // Hide the color picker
    }
}
