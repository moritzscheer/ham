/**
 * function to display image in preview field
 * * @param image
 */
function onImageAdd(image) {
    var preview = document.getElementById("image_preview");
    var newImage = new Image();

    input.addEventListener('change', () => {
        newImage.src = URL.createObjectURL(image.files[0]);
    })
    newImage.alt = "could not load image";
    preview.onload = function (){
        URL.revokeObjectURL(preview.src);
        preview.appendChild(newImage);
    }
}