# Feedback
Esse documento visa coletar feedbacks sobre o teste de desenvolvimento. Desde o início do teste até a entrega do projeto.

## Antes de Iniciar o Teste

1 - Fale sobre suas primeiras impressões do Teste:
> Estranhei, pois nunca fiz nada parecido, porém já vi essa funcionalidade
> em sistemas de marketing digital, para redirecionar usuários e ao mesmo
> tempo coletar dados para traçar estatísticas posteriormente.

2 - Tempo estimado para o teste:
> 4 dias.

3 - Qual parte você no momento considera mais difícil?
> Eu acredito que as partes do projeto que irei trabalhar com Headers.

4 - Qual parte você no momento considera que levará mais tempo?
> Na parte de testes manuais e criação de testes automatizados.

5 - Por onde você pretende começar?
> Vou desenhar o sistema primeiramente, ver projetos parecidos e a partir
> disso, vou começar a criação de modelos, controladores, rotas e factorys.
> Logo após essas etapas, vou seguir com a solução dos problemas descritos
> no README.md.


## Após o Teste

1 - O que você achou do teste?
> Muito completo, é um projeto completo. Nunca fiz nada parecido, mas
> já tinha uma leve noção de como funcionava. Foi legal desafiar-me
> a fazer esse teste, consegui implementar em algo real coisas que
> eu já sabia sobre o laravel (teoria e fazendo alguns exemplos),
> é uma experiência muito legal, aplicar algo que você nunca teve
> a oportunidade de aplicar de fato.

2 - Levou mais ou menos tempo do que você esperava?
> Menos.

3 - Teve imprevistos? Quais?
> Imprevisto não, mas não consegui implementar a validação de DNS da URL.

4 - Existem pontos que você gostaria de ter melhorado?
> Testes unitários e o visual hehe, como eu queria focar nas funcionalidades,
> deixei o visual o mais usável e "bonito" que eu consegui. Mas
> fora isso, fiz o meu melhor nesse tempo que dediquei para realização
> do teste. Mas claro, se eu voltar daqui a três dias, vou querer melhorar
> algo, refatorar também, enfim.

5 - Quais falhas você encontrou na estrutura do projeto?
> Relacionado a código, nenhuma falha, pois é um projeto Laravel 9
> zerado, limpo. Mas o README.md deixa muito a desejar na questão
> de explanar o erro e explicar como exatamente, com muita clareza
> o como e porque aquele problema deve ser resolvido.
> 
> Tem momentos que falam de testar se a URL retorna algo diferente
> de 200, mas em outra quer testar se retorna diferente de 200
> ou 201.
> 
> Não deixa claro como será o corpo das estatísticas de acessos,
> se as estatísticas de até 10 dias atrás serão dentro ou fora
> do retorno geral.
> 
> Outra coisa que percebi no final dos testes de estatísticas,
> ficou muito ambiguo:
> - Verificar se os acessos dos últimos 10 dias estão corretos 
> - Verificar se os acessos dos últimos 10 dias estão corretos quando não há acessos 
> - Verificar se os acessos dos últimos 10 dias estão corretos quando há acessos
> 
> Acabei considerando somente:
> - Verificar se os acessos dos últimos 10 dias estão corretos (com acessos)
> - Verificar se os acessos dos últimos 10 dias estão corretos quando não há acessos
>
> Acredito que somente isso, mas entendo que isso é muito comum.
> Eu poderia perguntar várias coisas, mas como eu tô fazendo esse
> teste no meu tempo livre (madrugada), não tenho muito espaço para
> explanar todas as minhas dúvidas.
