{if !empty($ads)}
        <div id="ad_container">
            <table>
                <tr class="caption">
                    <td>Название</td>
                    <td>Цена</td>
                    <td>Имя владельца</td>
                    <td>Удалить</td>

                    </tr>

                {foreach from = $ads key = key item = val}
                    <tr>
                        <td><a href="?id={$val.id}&show={$val.id}">{$val.name_ad}</a></td>
                        <td>{$val.price}</td>
                        <td>{$val.name}</td>
                        <td><a href="?id={$val.id}&del=1">Удалить</a></td>
                    </tr>
                {/foreach}
            </table>
        </div><!--End ad_container -->
{/if}