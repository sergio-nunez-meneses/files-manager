let myWindow;

// get all <a> tags containing files and open modal
const openFile = () => {
  const files = document.querySelectorAll('[class*="file"]');
  const patternFileExtension = /\.([0-9a-z]+)(?:[\?#]|$)/i;
  for (let n in files) {
    if (files.hasOwnProperty(n)) {
      files[n].addEventListener("click", e => {
        e.preventDefault();
        const url = files[n].getAttribute("href");
        files[n].style.display = 'block';
        files[n].style.width = "100%";
        files[n].style.height = "auto";
        myWindow = window.open(url, "myWindow", 'width=1000px,height=500px,resizable=1');
      });
    }
  }
}
// call function
openFile();
