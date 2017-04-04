{if !empty($ads)}
        <div id="ad_container">
            <table class="table table-hover">
                <tr>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Имя владельца</th>
                    <th>Удалить</th>
                </tr>

                {foreach from = $ads key = key item = val}
                    <tr>
                        <td><a href="?show={$key}">{$val->getNameAd()}</a></td>
                        <td>{$val->getPrice()}</td>
                        <td>{$val->getName()}</td>
                        <td><a href="?id={$key}&del=1" class="btn btn-danger">удалить</a></td>
                    </tr>
                {/foreach}
            </table>
        </div><!--End ad_container -->
{/if}