<template>
    <body>
        <div class="container">
            <main>
                <section class="content-header">CONTENT HEADER</section>
                <section><router-view/></section>
            </main>

            <aside class="left_sidebar" :class="{ isOpen : true }">Left sidebar</aside>
            <aside class="right_sidebar">Right sidebar</aside>

            <footer>FOOTER</footer>
            <header>
                <i class="fa fa-address-card"></i>
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                HEADER
            </header>
        </div>
    </body>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style>

    html,body, .container {
        margin: 0;
        height: 100%;
    }

    body {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-weight: 500;
        font-size: 14px;
        color: #333;
    }
    .container {
        display: grid;
        grid-template-columns: 100px 1fr 100px;
        grid-template-rows: 150px 1fr 100px;
    }
    .icon {
        display: inline-block;
        height: 1.25em;
        witdh: 1.25em;
        fill: currentColor;
    }

    main,header,footer,section{
        display: grid;
        border: solid black 1px;
    }

    main {
        background-color: blue;
        grid-row: 2;
        grid-column: 2;
    }

    header {
        background-color: darkred;
        grid-row-start: 1;
        grid-column-end: 4;
    }

    .content-header {
        background-color: yellow;
    }

    footer {
        background-color: beige;
        grid-row: 3;
        grid-column: 1;
    }

    section {
        background-color: aquamarine;
    }

    .left_sidebar {
        grid-row: 2;
        grid-column: 1;
    }

    .right_sidebar {
        grid-row: 2;
        grid-column: 3;
    }
</style>
