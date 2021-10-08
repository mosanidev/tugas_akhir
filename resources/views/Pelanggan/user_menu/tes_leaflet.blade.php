<!DOCTYPE html>
<html>
<body>

<h1>The onclick Event</h1>

<p>The onclick event is used to trigger a function when an element is clicked on.</p>

<p>Click the button to trigger a function that will output "Hello World" in a p element with id="demo".</p>

<button onclick="myFunction('etel')">Click me</button>

<p id="demo"></p>

<script>
function myFunction(e) {
  document.getElementById("demo").innerHTML = e;
}
</script>

</body>
</html>