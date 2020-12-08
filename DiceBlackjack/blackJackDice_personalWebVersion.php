<?php
    session_start();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>Dice Blackjack</title>
    <link rel="stylesheet" type="text/css" href="blackJackDiceStyle.css">
    <meta charset="utf-8"/>
</head>
<body>
    <div class="banner">
        <h3 class="title">Dice Blackjack</h3>
        <h2 class="subtitle">Like blackjack, but with dice...</h2>
    </div>
    
    <br>
    
    <div class = "gameScreen">
        <?php
            if ((isset($_GET['restart'])) || (isset($_GET['changeUser']))){
                $_SESSION['sum'] = 0;
                $_SESSION['pastRolls'] = array();
            }
            if((isset($_GET['changeUser']))){
                session_unset();
                session_destroy();
        ?>
                <div class="changeUser"><br><br>Enter Your Name
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                <input type="text" name="userName">
                <input type="submit" name="play" value="Play!">
                </form>
                </div>
        <?php
            }
            if (isset($_GET['play'])) { 
                 $_SESSION['name'] = $_GET['userName'];
            } 
            $_SESSION['sum'] = ((isset($_SESSION['sum'])) ? $_SESSION['sum'] : 0);
            if((isset($_GET['roll'])) || (isset($_REQUEST['play'])) || (isset($_GET['showInstructions'])) || (isset($_GET['hideInstructions'])) || (isset($_GET['restart']))){
                if (((isset($_GET['roll'])) || (isset($_GET['restart'])) || (isset($_GET['play']))) && ($_SESSION['sum'] <= 21)){
                    $result = rand(1, 11);
                    $_SESSION['randVal'] = $result;
                }
                echo "<div class='rollValDiv'>";
                echo "<h3>You rolled: ", $_SESSION['randVal'], "</h3>";
                echo "</div>";
                echo "<div class='rollDiv'>";
                diceImages($_SESSION['randVal']);
                echo "</div>";
                if(!isset($_SESSION['pastRolls'])){
                    $_SESSION['pastRolls'] = array();
                }
                if (((isset($_GET['roll'])) || (isset($_GET['restart'])) || (isset($_GET['play']))) && ($_SESSION['sum'] <= 21)){
                    $_SESSION['sum'] += $result;
                    $_SESSION['pastRolls'][] = $result;
                }
                echo "<div class='pastRollsDiv'>";
                foreach($_SESSION['pastRolls'] as $pastRoll){
                    pastRollImg($pastRoll);
                }
                echo "</div>";
                if ($_SESSION['sum'] > 21){
                    echo "<div class='playerScoreLose'>";
                    echo "<div class='scoreTitle'>You Busted</div>";
                    echo "<div class='score'>", $_SESSION['sum'], "</div>";
                    echo "</div>";
                    echo "<div class='loser'>";
                    echo "<h1 class='winOrLose'> You lose, loser. </h1>";
                    echo "</div>";
                }
                else{
                    echo "<div class='playerScore'>";
                    echo "<div class='scoreTitle'>", $_SESSION['name'], "</div>";
                    echo "<div class='score'>", $_SESSION['sum'], "</div>";
                    echo "</div>";
                }
            }
            elseif(isset($_GET['stay'])){
                echo "<div class='pastRollsDiv'>";
                foreach($_SESSION['pastRolls'] as $pastRoll){
                    pastRollImg($pastRoll);
                }
                echo "</div>";
                if ($_SESSION['sum'] <= 21){
                    echo "<div class='playerScore'>";
                    echo "<div class='scoreTitle'>You Stayed</div>";
                }
                else{
                    echo "<div class='playerScoreLose'>";
                    echo "<div class='scoreTitle'>You Busted</div>";
                }
                echo "<div class='score'>", $_SESSION['sum'], "</div>";
                echo "</div>";
                dealerTurn($_SESSION['sum']);
            }
                    
            
            function dealerTurn($playerScore) {
                $dealerScore = 0;
                $dealerRoll = 0;
                $dealerCount = 0;
                $dealerPastRolls = array();
                while (($dealerScore < $playerScore) || $dealerScore == 0){
                    $dealerRoll = rand(1, 11);
                    $dealerPastRolls[] = $dealerRoll;
                    $dealerScore += $dealerRoll;
                    $dealerCount++;
                }
                echo "<div class='dealerPastRollsDiv'>";
                foreach ($dealerPastRolls as $pastRoll){
                    pastRollImg($pastRoll);
                }
                echo "</div>";
                if ($dealerScore > 21){
                    echo "<div class='dealerScoreLose'>";
                    echo "<div class='scoreTitle'>Dealer Busts</div>";
                    echo "<div class='score'>", $dealerScore, "</div>";
                    echo "</div>";
                }
                else {
                    echo "<div class='dealerScore'>";
                    echo "<div class='scoreTitle'>Dealer Score</div>";
                    echo "<div class='score'>", $dealerScore, "</div>";
                    echo "</div>";
                }
                if ($playerScore > 21){
                    echo "<div class='loser'>";
                    echo "<h1 class='winOrLose'> You lose, loser. </h1>";
                    echo "</div>";
                }
                elseif ($dealerScore > 21 || $dealerScore < $playerScore){
                    echo "<div class='winner'>";
                    echo "<h1 class='winOrLose'> WINNER! </h1>";
                    echo "</div>";
                }
                elseif ($dealerScore == $playerScore){
                    echo "<div class='loser'>";
                    echo "<h1 class='winOrLose'> You lose, loser. </h1>";
                    echo "</div>";
                }
                else{
                    echo "<div class='loser'>";
                    echo "<h1 class='winOrLose'> You lose, loser. </h1>";
                    echo "</div>";
                }
            }
            
            function diceImages($value) {
                if ($value == 1){
                    echo "<img class='diceImg' src = 'Images/die1.png' alt = 'dice roll'>";
                }
                elseif ($value == 2){
                    echo "<img class='diceImg' src = 'Images/die2.png' alt = 'dice roll'>";
                }
                elseif ($value == 3){
                    echo "<img class='diceImg' src = 'Images/die3.png' alt = 'dice roll'>";
                }
                elseif ($value == 4){
                    echo "<img class='diceImg' src = 'Images/die4.png' alt = 'dice roll'>";
                }
                elseif ($value == 5){
                    echo "<img class='diceImg' src = 'Images/die5.png' alt = 'dice roll'>";
                }
                elseif ($value == 6){
                    echo "<img class='diceImg' src = 'Images/die6.png' alt = 'dice roll'>";
                }
                elseif ($value == 7){
                    echo "<img class='diceImg' src = 'Images/die7.png' alt = 'dice roll'>";
                }
                elseif ($value == 8){
                    echo "<img class='diceImg' src = 'Images/die8.png' alt = 'dice roll'>";
                }
                elseif ($value == 9){
                    echo "<img class='diceImg' src = 'Images/die9.png' alt = 'dice roll'>";
                }
                elseif ($value == 10){
                    echo "<img class='diceImg' src = 'Images/die10.png' alt = 'dice roll'>";
                }
                elseif ($value == 11){
                    echo "<img class='diceImg' src = 'Images/die11.png' alt = 'dice roll'>";
                }
            }
            
            function pastRollImg($value) {
                if ($value == 1){
                    echo "<img class='pastRollDice' src = 'Images/die1.png' alt = 'past dice roll'>";
                }
                elseif ($value == 2){
                    echo "<img class='pastRollDice' src = 'Images/die2.png' alt = 'past dice roll'>";
                }
                elseif ($value == 3){
                    echo "<img class='pastRollDice' src = 'Images/die3.png' alt = 'past dice roll'>";
                }
                elseif ($value == 4){
                    echo "<img class='pastRollDice' src = 'Images/die4.png' alt = 'past dice roll'>";
                }
                elseif ($value == 5){
                    echo "<img class='pastRollDice' src = 'Images/die5.png' alt = 'past dice roll'>";
                }
                elseif ($value == 6){
                    echo "<img class='pastRollDice' src = 'Images/die6.png' alt = 'past dice roll'>";
                }
                elseif ($value == 7){
                    echo "<img class='pastRollDice' src = 'Images/die7.png' alt = 'past dice roll'>";
                }
                elseif ($value == 8){
                    echo "<img class='pastRollDice' src = 'Images/die8.png' alt = 'past dice roll'>";
                }
                elseif ($value == 9){
                    echo "<img class='pastRollDice' src = 'Images/die9.png' alt = 'past dice roll'>";
                }
                elseif ($value == 10){
                    echo "<img class='pastRollDice' src = 'Images/die10.png' alt = 'past dice roll'>";
                }
                elseif ($value == 11){
                    echo "<img class='pastRollDice' src = 'Images/die11.png' alt = 'past dice roll'>";
                }
            }
            
            function printInstructions(){
                echo "<div class='instructionDiv'>";
                echo "<h3 class='instructionHeader'>Instructions:</h3>";
                echo "<p class = instructionPar'>
                    The objective of this game is simple: Get your score as close as you can to 21, <strong>without</strong> going over.<br>
                    Start by entering your name and hitting 'Play!' The game will automatically roll for you the first time.<br>
                    Each turn, you can hit 'Roll Again' to roll the die again or you can hit 'Stay' to stay with your current score and allow the dealer to roll.<br>
                    <strong>BUT BEWARE!</strong> If your rolls add up to more than 21, you automatically lose!<br>
                    The dealer will automatically roll when you hit 'Stay'. If the Dealer's total is greater than your's, the Dealer wins. Tie goes to the Dealer.<br>
                    But the Dealer can bust if he rolls above 21 causing you to win the game! You also win if your total score is greater than the Dealer's. Hooray!<br>
                    Your past rolls can be seen in the top right and your current score in the bottom right.<br>
                    <strong>Have fun!</strong>
                    </p>";
                echo "</div>";
            }
            
        ?>
    </div>
    
    <div class="buttonsDiv">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="submit" name="roll" value="Roll Again">
        <input type="submit" name="stay" value="Stay">
        <input type="submit" name="changeUser" value="Change User">
        <input type="submit" name="restart" value="Restart">
        <input type="submit" name="showInstructions" value="Show Instructions">
        <input type="submit" name="hideInstructions" value="Hide Instructions">
        </form>
    </div>
    
        <?php
            if (isset($_GET['hideInstructions'])){
                $_SESSION['instructions'] = 0;
            }
            if ((isset($_GET['showInstructions'])) || ($_SESSION['instructions'] == 1)){
                printInstructions();
                $_SESSION['instructions'] = 1;
            }
        ?>
        
        <br><br>
        Last updated
        <script>
            document.write(document.lastModified);
        </script>

</body>
</html>
