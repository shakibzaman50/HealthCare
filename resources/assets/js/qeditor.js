const fullToolbar = [
  [
    { font: [] },
    { size: [] }
  ],
  ['bold', 'italic', 'underline', 'strike'],
  [
    { color: [] },
    { background: [] }
  ],
  [
    { script: 'super' },
    { script: 'sub' }
  ],
  [
    { header: '1' },
    { header: '2' },
    'blockquote',
    'code-block'
  ],
  [
    { list: 'ordered' },
    { list: 'bullet' },
    { indent: '-1' },
    { indent: '+1' }
  ],
  [
    'direction',
    { align: [] }
  ],
  ['link', 'image', 'video', 'formula'],
  ['clean']
];

function initializeQuillEditor() {
  // Initialize Quill editor in the new container
  var quill = new Quill('#quill-editor', {
    modules: {
      formula: true,
      toolbar: fullToolbar
    },
    theme: 'snow', // Or 'bubble'
  });

  // Get the hidden textarea
  var textarea = document.querySelector('#full-editor');

  // Set the initial content of the editor
  quill.root.innerHTML = textarea.value;

  // Update the hidden textarea when Quill content changes
  quill.on('text-change', function() {
    textarea.value = quill.root.innerHTML;
  });
}

// Run the function when the page loads
window.onload = initializeQuillEditor;
