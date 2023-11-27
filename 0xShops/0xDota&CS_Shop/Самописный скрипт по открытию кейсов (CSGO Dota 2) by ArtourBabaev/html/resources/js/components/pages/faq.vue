<template>
    <div>
        <div class="branding profile-brand">
            <div class="main-width clear"></div>
        </div>
        <div class="content">
            <div class="main-width">
                <div class="page-title"><span>FAQ</span> - часто задаваемые вопросы</div>
                <div>
                    <div rel="faq_1" class="faq-item" :class="[this.faq_1 ? 'active' : '']" v-on:click="open(1)">
                        <div class="faq-heading">Что делать, если после пополнения баланса деньги не поступили на счет?
                        </div>
                        <div aria-hidden="true" class="faq-content rah-static--height-zero"
                             style="height: auto; overflow: hidden;">
                            <div :style="{display: this.faq_1 ? 'block' : 'none'}">
                                <div class="text">После оплаты необходимо подождать, если спустя час, деньги не
                                    поступили,
                                    пожалуйста, обратитесь в поддержку, указав реквизиты платежа, скриншот и ссылку на
                                    Ваш
                                    профиль с сайта.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div rel="faq_2"  class="faq-item" :class="[this.faq_2 ? 'active' : '']" v-on:click="open(2)">
                        <div class="faq-heading">Что делать, если предмет не пришел или вы не можете его забрать?</div>
                        <div aria-hidden="true" class="faq-content rah-static--height-zero"
                             style="height: auto; overflow: hidden;">
                            <div :style="{display: this.faq_2 ? 'block' : 'none'}">
                                <div class="text">Всё просто! Наиболее частые причины проблем с выводом предмета – бан
                                    трейда,
                                    скрытый инвентарь или отсутствие ссылки на обмен. В таком случае вам необходимо
                                    обратиться в
                                    нашу службу поддержки, и мы постараемся максимально быстро решить проблему.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div rel="faq_3"  class="faq-item" :class="[this.faq_3 ? 'active' : '']" v-on:click="open(3)">
                        <div class="faq-heading">Что делать, если к вам добавился в стиме под видом нашего сотрудника?
                        </div>
                        <div aria-hidden="true" class="faq-content rah-static--height-zero"
                             style="height: auto; overflow: hidden;">
                            <div :style="{display: this.faq_3 ? 'block' : 'none'}">
                                <div class="text">Остерегайтесь подобных сообщений! Мы никогда не добавимся в стим, тем
                                    более не
                                    станем просить вещи! Мошенники будут пытаться любым способом получить Ваши предметы!
                                    Будьте
                                    бдительны!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div rel="faq_4"  class="faq-item" :class="[this.faq_4 ? 'active' : '']" v-on:click="open(4)">
                        <div class="faq-heading">Можно ли перевести средства со счета Steam?</div>
                        <div aria-hidden="true" class="faq-content rah-static--height-zero"
                             style="height: auto; overflow: hidden;">
                            <div :style="{display: this.faq_4 ? 'block' : 'none'}">
                                <div class="text">Нет, к сожалению Steam не предоставляет никаких способов для вывода
                                    средств с
                                    их счета.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div rel="faq_5"  class="faq-item" :class="[this.faq_5 ? 'active' : '']" v-on:click="open(5)">
                        <div class="faq-heading">Как продать или вывести предмет с сайта?</div>
                        <div aria-hidden="true" class="faq-content rah-static--height-zero"
                             style="height: auto; overflow: hidden;">
                            <div :style="{display: this.faq_5 ? 'block' : 'none'}">
                                <div class="text">В профиле пользователя, на иконке скина, нужно выбрать действие,
                                    которое
                                    вы
                                    решили совершить. "Забрать" - будет произведена покупка предмета на торговой
                                    площадке,
                                    после
                                    чего Вам будет отправлен выбранный предмет. "Продать" - продажа предмета сайту,
                                    мгновенно
                                    получаете его стоимость на баланс.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                faq_1: false,
                faq_2: false,
                faq_3: false,
                faq_4: false,
                faq_5: false
            }
        },
        methods: {
            open(id) {
                const vm = this;
                switch (id) {
                    case 1:
                        if (vm.faq_1) {
                            vm.faq_1 = false;
                        } else {
                            vm.faq_1 = true;
                        }
                        break;
                    case 2:
                        if (vm.faq_2) {
                            vm.faq_2 = false;
                        } else {
                            vm.faq_2 = true;
                        }
                        break;
                    case 3:
                        if (vm.faq_3) {
                            vm.faq_3 = false;
                        } else {
                            vm.faq_3 = true;
                        }
                        break;
                    case 4:
                        if (vm.faq_4) {
                            vm.faq_4 = false;
                        } else {
                            vm.faq_4 = true;
                        }
                        break;
                    case 5:
                        if (vm.faq_5) {
                            vm.faq_5 = false;
                        } else {
                            vm.faq_5 = true;
                        }
                        break;
                }
            }
        }
    }
</script>