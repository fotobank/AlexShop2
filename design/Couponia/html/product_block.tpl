                        <div class="{if $main}col-md-3{else}col-md-4{/if} product">
                            <div class="product-thumb">
                                <header class="product-header  hover-img">
                                 {if $product->variant->compare_price>0}
                                <span class="product-label label label-danger">-{round(abs(100-{$product->variant->price}/($product->variant->compare_price)*100))}%</span>                               
                                {elseif $product->featured}
                                <span class="product-label label label-info">Хит</span>
                                {/if}
                                <a href="products/{$product->url}" class="product_image image">
                                    <img  src="{$product->image->filename|resize:200:200}" alt="{$product->name|escape}" title="{$product->name|escape}" />
                                    </a>
                                    {if $product->variant->compare_price>0}
                                    <h5 class="hover-title hover-title-hide">Ваша экономия  {($product->variant->compare_price - $product->variant->price)|convert} {$currency->sign|escape}</h5>
                                    {/if}
                                </header>
                                <div class="product-inner">

                                    <h5 class="product-title"> <a href="products/{$product->url}">{$product->name|escape}</a></h5>
                                    <p class="product-desciption">{$product->annotation|strip_tags|truncate:100}</p>
                                    <div class="product-meta">
                                        <ul class="product-price-list">
                                        {if $product->variants|count > 0}
                                            <li><span class="product-price"><span class="pr">{$product->variant->price|convert}</span> {$currency->sign|escape}</span>
                                            </li>
                                            {if $product->variant->compare_price>0}
                                            <li><span class="product-old-price"><span class="old">{$product->variant->compare_price|convert}</span> {$currency->sign|escape}</span>
                                            </li>
                                            <li><span class="product-save">Скидка <span class="save">{round(abs(100-{$product->variant->price}/($product->variant->compare_price)*100))}</span>%</span>
                                            </li>
                                            {/if}
                                            {else}
                                             <li><span class="product-price">Нет в наличии</span>
                                            </li>                                           
                                            {/if}
                                        </ul>
                                        <form class="variants" action="/cart">
                                        {if $product->variants|count > 0}
											{* Не показывать выбор варианта, если он один и без названия *}
											<select name="variant" {if $product->variants|count==1  && !$product->variant->name}style='display:none;'{/if}>
												{foreach $product->variants as $v}
												<option value="{$v->id}" {if $v->compare_price > 0}compare_price="{$v->compare_price|convert}"{/if} price="{$v->price|convert}">
												{$v->name}
												</option>
												{/foreach}
											</select>
											<!-- Выбор варианта товара (The End) -->  
										{/if}                                         
                                        <ul class="product-actions-list">
                                          {if $product->variants|count > 0}
                                            <li><button class="btn btn-sm"  type="submit"><i class="fa fa-shopping-cart"></i> В корзину</button>
                                            </li>
                                            {/if}
                                            <li><a class="btn btn-sm"  href="products/{$product->url}"><i class="fa fa-bars"></i> Детали</a>
                                            </li>
                                        </ul>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>