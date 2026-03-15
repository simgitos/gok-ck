<form name="logowanie" method="post" action="logowanie.php">
        <table border="0" cellspacing="0" cellpadding="2">
            <tr>
                <td class="uni_01" align="right"> login:</td>
                <td class="uni_01">
                    <input type="text" name="log">
                </td>
            </tr>
            <tr>
                <td class="uni_01" align="right">hasło: </td>
                <td class="uni_01">
                    <input type="password" name="has">
                    <input type="hidden" name="cmd" value="logowanie">
                </td>
            </tr>
            <tr>
                <td class="uni_01">&nbsp;</td>
                <td class="uni_01">
                    <input style="font-weight: bold;" type="submit" name="ok" value="zaloguj">
                </td>
            </tr>
        </table>
    </form>
   <?php if (!empty($error)) {
        echo '<p class="danger">'.$error.'</p>'; // Wyświetla błąd w czerwonym kolorze
    }
    ?>