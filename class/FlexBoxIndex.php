<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <section id="content">
            <article class="item">01</article>
            <article class="item">02</article>
            <article class="item">03</article>
            <article class="item">04</article>
        </section>
        
        <style>
            #content {
                background: #e7eef5;
                width: 500px;
                height: 500px;
                display: flex;
                flex-direction: row; /*row, column, row-reverse, column-reverse*/
                flex-wrap: wrap;
            }
            
            .item{
                height: 100px;
                width: 250px;
                color: black;
                -webkit-box-shadow: 0px 2px 8px -1px rgba(0,0,0,0.24);
                background: white;
                margin: 5px;
            }
        </style>
    </body>
</html>
