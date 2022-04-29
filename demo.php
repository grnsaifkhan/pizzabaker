<html>
<head>
    <style>
        /* Style the div with the "red" class to have a red background */
        .red{
            background-color:red;
        }


        /* Style the div with the "blue" class to have a blue background */
        .blue{
            background-color: blue;
        }
        .red.blue{
            background-color: purple;
        }

        /* Style the div with the "red blue" classes to have a purple background */

    </style>

    <script type="text/javascript">
        //give all elements with the css class "red" the text content "Text changed by javascript"
        var elements = document.getElementsByClassName("red");
        for(var i=0;i<elements.length;i++)
        {
            elements[i].innerHTML = 'Testing here';
        }


        //Do an AJAX Request to "https://jsonplaceholder.typicode.com/todos/1". Fill the "blue" container with information you get back from there.

    </script>

</head>
<body>

<div class="red">
    Red div
</div>

<div class="blue">
    Blue div
</div>

<div class="red blue">
    Purple div
</div>

</body>
</html>
