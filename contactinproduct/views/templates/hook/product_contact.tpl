<div class="supplier-contact-box">
  <h4>ارتباط مستقیم با تأمین‌کننده ها</h4>
  {foreach from=$contacts item=contact}
    <div class="supplier-row">
      <span class="supplier-name">{$contact.title|escape:'html':'UTF-8'}</span>
      <span class="supplier-phone">{$contact.mobile|escape:'html':'UTF-8'}</span>
    </div>
  {/foreach}
</div>
