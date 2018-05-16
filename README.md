Поводом для написания данного скрипта послужила ситуация с игровыми серверами PSN.

Так, публичные DNS резолвери множество ответов по запросам от игровых приставок, часть которых была в спиках РКН. Приставка же, не понимала особенностей национального фаервола и брала первый IP из списка.

Данный скрипт обращается к роутеру микротик по средствам API, проверяя DNS кэш и внося статические записи после проверки вхождения резолвируемых IP в реестр РКН.

Пример:

Сервер провайдера:

nslookup elb001-mtc-ag21.mtc.usw2.np.cy.s0.playstation.net
Server: 192.168.1.1
Address: 192.168.1.1#53

Non-authoritative answer:
Name: elb001-mtc-ag21.mtc.usw2.np.cy.s0.playstation.net
Address: 52.24.34.174
Name: elb001-mtc-ag21.mtc.usw2.np.cy.s0.playstation.net
Address: 34.213.199.175
Name: elb001-mtc-ag21.mtc.usw2.np.cy.s0.playstation.net
Address: 35.163.190.236
Name: elb001-mtc-ag21.mtc.usw2.np.cy.s0.playstation.net
Address: 34.211.105.107

Наш DNS:

nslookup elb001-mtc-ag21.mtc.usw2.np.cy.s0.playstation.net 192.168.1.66
Server: 192.168.1.66
Address: 192.168.1.66#53

Non-authoritative answer:
Name: elb001-mtc-ag21.mtc.usw2.np.cy.s0.playstation.net
Address: 52.24.34.174