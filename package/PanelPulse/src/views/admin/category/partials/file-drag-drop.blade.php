<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

.form-container {
	width: 100vw;
	height: 100vh;
	background-color: #7b2cbf;
	display: flex;
   	justify-content: center;
	align-items: center;
}
.upload-files-container {
    background-color: #f9f9f9;
	width: 100%;
	display: flex;
   	align-items: center;
   	justify-content: center;
	flex-direction: column;
    padding: 12px;
    border-radius: 19px;
}
.drag-file-area {
    position: relative;
	border: 2px dashed #d1d1d1;
	border-radius: 12px;
	text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
}
.drag-file-area .upload-icon {
	font-size: 24px;
    margin-right: 10px;
}
.drag-file-area h3 {
	font-size: 18px;
	margin: 0;
}
.drag-file-area label {
	font-size: 19px;
}
.drag-file-area label .browse-files-text {
	color: #7b2cbf;
	font-weight: bolder;
	cursor: pointer;
}
.preview-container, .media-container {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: left;
}
.preview-item, .media-item {
    position: relative;
    width: 100px;
    height: 100px;
    border: 2px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.preview-item img, .media-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.preview-item .remove-preview, .media-item .remove-preview {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
}
.upload-button {
	font-family: 'Montserrat';
	background-color: #7b2cbf;
	color: #f7fff7;
	display: flex;
	align-items: center;
	font-size: 18px;
	border: none;
	border-radius: 20px;
	margin: 10px;
	padding: 7.5px 50px;
	cursor: pointer;
}
.default-file-input{
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
</style>

<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">

<label class="fw-bold">Media</label>
<div class="upload-files-container">

	<div class="drag-file-area w-100">
        <input multiple type="file" class="default-file-input" name="file[]"/>
		<span class="material-icons-outlined upload-icon"> file_upload </span>
		<h3 class="dynamic-message"> Drag & drop files here </h3>
	</div>

	<div class="preview-container"></div>

</div>

@section('scriptContent')
<script>
    let fileInput = document.querySelector(".default-file-input");
    let previewContainer = document.querySelector(".preview-container");
    let form = document.querySelector('form');
    let filesList = [];

    // Handle the file selection via drag-and-drop
    fileInput.addEventListener("change", handleFileInput);

    function handleFileInput(event) {
        const files = Array.from(event.target.files);
        files.forEach((file) => {
            filesList.push(file);
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement("div");
                previewItem.classList.add("mt-2", "preview-item");
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button class="remove-preview">&times;</button>
                `;

                previewItem.querySelector(".remove-preview").addEventListener("click", () => {
                    filesList = filesList.filter(f => f.name !== file.name);
                    previewItem.remove();
                });

                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    // Add selected files to the form before submit
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission for handling it in JavaScript

        // Check if files are added
        if (filesList.length > 0) {
            // Add files to hidden input
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'file';
            hiddenInput.name = 'file[]'; // Ensures array of files
            hiddenInput.multiple = true;

            filesList.forEach(file => {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                hiddenInput.files = dataTransfer.files;
            });

            // Append the hidden file input to the form
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        } else {
            alert('Please select at least one file!');
        }
    });
</script>

@endsection
