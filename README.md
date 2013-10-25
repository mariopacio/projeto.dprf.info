## DPRF.info

Aplicativo para visualização de estatísticas dos acidentes de trânsito nas rodovias federais a partir de 2007. 
Visualize as informações de forma fácil e organizada com filtragens por semestre, trimestre, mês e dia.

Principais recursos do aplicativo:

 * Comparativos percentuais com períodos anteriores.
 * Mapeamento por faixa de idade dos condutores envolvidos em acidentes.
 * Mapeamento do sexo dos condutores.
 * Principais trechos onde acontecem mais ocorrências.
 * Divisão de acidentes por rodovias(BR/UF) e divisão por trechos da rodovia.
 * Marcas de veículos mais envolvidas em acidentes.
 * Modelos de veículos mais envolvidas em acidentes, com detalhamento da faixa de ano dos veículos.
 * Geolocalização dos acidentes.
 * Tipos de acidentes mais comuns por período.
 * Causas de acidentes mais comuns por período.
 * Mapeamento dos "Tipos de acidentes X Causas de acidente".
 * Mapeamento dos "Tipos de acidentes X Causas de acidente" por faixa de idade dos condutores.
 * Sistema de busca inteligente para datas e rodovias.
 * QRCode inteligente para acesso aos resultados de tablets e celulares.
 * Horas e dias da semana com mais acidentes.
 * Trace o perfil dos trechos das rodovias individualmente e saiba quais os acidentes mais comuns para cada trecho das 
   rodovias, os horários mais críticos e visualize no mapa a localização aproximada dos locais mais críticos.


## Informações para configuração do DPRF.info.

Para instalar o aplicativo **DPRF.info** serão necessários os seguintes recursos:

* Apache com PHP 5+
* MySQL 

### **Base de dados:**

Os bancos de dados utilizados são fornecidos de acordo com a política de dados abertos no seguinte endereço: 
[http://dados.gov.br/dataset/acidentes-rodovias-federais](http://dados.gov.br/dataset/acidentes-rodovias-federais)

### Configurações do banco de dados

Os dados de acesso ao seu banco de dados devem ser alteradas no arquivo: **/infodprf.class.php**

_Trecho do código:_
*     `public function __construct(){`
*          `// Conecta no banco de dados`
*          `mysql_connect('localhost', 'root');`
*          `mysql_select_db('dprf');`
*     `}`

### Configurações do layout

É possível alterar o tema do conteúdo para claro/escuro com apenas um comando, no **index.php**!

* `// Seta o tema do conteúdo (clean/dark)`
* `$infoDPRF->setTheme('clean');`


### Autores
* **Mário Pácio**
E-mail: mario.pacio@gmail.com
Website: www.mariopacio.com

* **Weslen Finotti**
E-mail: contato@fastmark.com.br


### Organização
* [W3C Brasil](http://www.w3c.br/)
* [Ministério da Justiça](http://portal.mj.gov.br/)
* [Polícia Rodoviária Federal](http://www.dprf.gov.br/)

### Licença
http://www.gnu.org/licenses/agpl-3.0.html

### O Projeto

Departamento de Polícia Rodoviária Federal
Base de dados aberto sobre boletins de ocorrências de trânsito nas rodovias federais

O concurso, em parceria com o Ministério da Justiça (Secretaria Executiva e Departamento da Polícia Rodoviária Federal), a Controladoria-Geral da União e o Ministério do Planejamento, Orçamento e Gestão (SLTI), ocorre sobre a base de dados do Sistema de Informações Gerenciais (SIGER), mantida pelo Departamento de Polícia Rodoviária Federal, que poderá ser cruzada com outras bases de dados para gerar aplicações.

De acordo com o Ministerio da Justiça, “os boletins de ocorrências de trânsito nas rodovias federais contêm informações detalhadas desde 2007 sobre cada acidente registrado pela PRF. São mais de um milhão de registros com dezenas de informações, como características dos veículos envolvidos, causa identificada do acidente, quantidade de pessoas envolvidas e descrição completa do ocorrido. Também será publicada a base de dados de autuações de trânsito”.

Fonte: iMasters/Ministério da Justiça


