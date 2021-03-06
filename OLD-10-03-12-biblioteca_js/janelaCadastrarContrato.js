function cadastrarContrato(codContratoSelecionado){
	
	function usuarioExcluir(value){
		if(value == 1){
			return '<center><img src="img/ic_desativar.png" /></center>'
		}else{
			return '<center><img src="img/ic_ativar.png" /></center>'
		}
	}


	function manterPessoa(coluna,statusUsuario,codPessoa){
		//if(coluna == 13){
			if(statusUsuario == 1){
				if(confirm('Tem certeza que deseja desativar esse Usu�rio?')){
					Ext.Ajax.request({
						url: 'modulos/usuario/gerenciar_usuario.php',
						params: { 
							acao         : 'pessoaGerenciar',
							codPessoa    :  codPessoa,
							statusUsuario: 0
						},
						callback: function(options, success, response) {
							
							var retorno = Ext.decode(response.responseText);
							
							if(retorno.success == false){
								Ext.MessageBox.alert('Mensagem','Usu�rio Desativado com sucesso!')
							}else{
								pessoaStore.reload()
							}
						}
					})
				}
			}else{
				if(confirm('Tem certeza que deseja ativar esse Usu�rio?')){
					Ext.Ajax.request({
						url: 'modulos/usuario/gerenciar_usuario.php',
						params: { 
							acao: 'pessoaGerenciar',
							codPessoa:  codPessoa,
							statusUsuario: 1
						},
						callback: function(options, success, response) {
							
							var retorno = Ext.decode(response.responseText);
							
							if(retorno.success == false){
								msg('Erro', 'Erro ao tentar executar a opera��o!')
							}else{
								pessoaStore.reload()
							}
						}
					})
				}
			}
		//}
	}


	//Proprietario
	var storeProprietario = new Ext.data.Store({
		id: 'storeProprietario',
		proxy: new Ext.data.HttpProxy({
			url: 'modulos/usuario/gerenciar_usuario.php',
			method: 'POST'
		}),
		baseParams:{
				acao: "proprietarioListar"
		},
		reader: new Ext.data.JsonReader({
			root: 'resultado',
			totalProperty: 'total',
			id: ['codPessoa','nome']
		},[ 
			{name: 'codPessoa', type: 'int'},
			{name: 'nome', type: 'string'}

		]),
		sortInfo:{field: 'nome', direction: "ASC"}
	}) 
	storeProprietario.load()


	//Proprietario
	var storeContratante = new Ext.data.Store({
		id: 'storeContratante',
		proxy: new Ext.data.HttpProxy({
			url: 'modulos/usuario/gerenciar_usuario.php',
			method: 'POST'
		}),
		baseParams:{acao: "locadorListar"},
		reader: new Ext.data.JsonReader({
			root: 'resultado',
			totalProperty: 'total',
			id: ['codPessoa','nome']
		},[ 
			{name: 'codPessoa', type: 'int'},
			{name: 'nome', type: 'string'}

		]),
		sortInfo:{field: 'nome', direction: "ASC"}
	}) 
	storeContratante.load()

	
	//Im�vel
	var storeImovel = new Ext.data.Store({
		id: 'storeImovel',
		proxy: new Ext.data.HttpProxy({
			url: 'modulos/imovel/gerenciar_imovel.php',
			method: 'POST'
		}),
		baseParams:{
			acao: "imovelProprietarioListar",
			codProprietario: 0
		},
		reader: new Ext.data.JsonReader({
			root: 'resultado',
			totalProperty: 'total',
			id: ['codImovel','endereco']
		},[ 
			{name: 'codImovel', type: 'int'},
			{name: 'endereco', type: 'string'}

		]),
		sortInfo:{field: 'codImovel', direction: "ASC"}
	}) 
	storeImovel.load()




	var msg = function(title, msg){
		Ext.Msg.show({
			title: title, 
			msg: msg,
			minWidth: 200,
			modal: true,
			icon: Ext.Msg.INFO,
			buttons: Ext.Msg.OK
		});
	};

	var storeProfissao = new Ext.data.Store({
		id: 'storeProfissao',
		proxy: new Ext.data.HttpProxy({
			url: 'modulos/usuario/gerenciar_usuario.php',
			method: 'POST'
		}),
		baseParams:{acao: "profissaoListar"},
		reader: new Ext.data.JsonReader({
			root: 'resultado',
			totalProperty: 'total',
			id: ['codProfissao','nome']
		},[ 
			{name: 'codProfissao', type: 'int'},
			{name: 'nome', type: 'string'}

		]),
		sortInfo:{field: 'nome', direction: "ASC"}
	}) 

	storeProfissao.load()

	var ufStore = new Ext.data.Store({
		id: 'ufStore',
		proxy: new Ext.data.HttpProxy({
			url: 'modulos/diversos/gerenciar_uf.php',
			method: 'POST'
		}),
		baseParams:{acao: "ufListar"},
		reader: new Ext.data.JsonReader({
			root: 'resultado',
			totalProperty: 'total',
			id: ['uf']
		},[ 
			{name: 'uf', type: 'string'}

		]),
		sortInfo:{field: 'uf', direction: "ASC"}
	}) 

	ufStore.load()
		
	
	//Tipo de Im�vel
	var storeTipoImovel = new Ext.data.Store({
		id: 'storeTipoImovel',
		proxy: new Ext.data.HttpProxy({
			url: 'modulos/imovel/gerenciar_imovel.php',
			method: 'POST'
		}),
		baseParams:{acao: "listarTipoImovel"},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ['codTipoImovel','nome']
		},[ 
			{name: 'codTipoImovel', type: 'int'},
			{name: 'nome', type: 'string'}

		]),
		sortInfo:{field: 'nome', direction: "ASC"}
	}) 

	storeTipoImovel.load()


		

	function imovelEditar(value){
		return '<center><img src="img/ic_editar.png" /></center>'
	}

	function imovelExcluir(value){
		if(value == 1){
			return '<center><img src="img/ic_desativar.png" /></center>'
		}else{
			return '<center><img src="img/ic_ativar.png" /></center>'
		}
	}

	function verificarAtivo(value){
		if(value == true){
			return 'sim'
		}else{
			return 'n�o'
		}
	}

	pessoaStore = new Ext.data.Store({
		id: 'pessoaStore',
		proxy: new Ext.data.HttpProxy({
			url: 'modulos/usuario/gerenciar_usuario.php',
			method: 'POST'
		}),
		baseParams:{acao: "pessoaVwListar"},
		reader: new Ext.data.JsonReader({
			root: 'resultado',
			totalProperty: 'total',
			id: ['codPessoa','email','nome']
		},[ 
			{name: 'codPessoa', type: 'int', mapping: 'codPessoa'},
			{name: 'email', type: 'string', mapping: 'email'},
			{name: 'nome', type: 'string', mapping: 'nome'},
			{name: 'endereco', type: 'string', mapping: 'endereco'},
			{name: 'bairro', type: 'string', mapping: 'bairro'},
			{name: 'cep', type: 'string', mapping: 'cep'},
			{name: 'cidade', type: 'string', mapping: 'cidade'},
			{name: 'uf', type: 'string', mapping: 'uf'},
			{name: 'codTipoPessoa', type: 'int', mapping: 'codTipoPessoa'},
			{name: 'tipoPessoa', type: 'string', mapping: 'tipoPessoa'},
			{name: 'enderecoTrabalho', type: 'string', mapping: 'enderecoTrabalho'},
			{name: 'cidadeTrabalho', type: 'string', mapping: 'cidadeTrabalho'},
			{name: 'bairroTrabalho', type: 'string', mapping: 'bairroTrabalho'},
			{name: 'cepTrabalho', type: 'string', mapping: 'cepTrabalho'},
			{name: 'ufTrabalho', type: 'string', mapping: 'ufTrabalho'},
			{name: 'codProfissao', type: 'int', mapping: 'codProfissao'},
			{name: 'profissao', type: 'string', mapping: 'profissao'},
			{name: 'codEstadoCivil', type: 'int', mapping: 'codEstadoCivil'},
			{name: 'estadoCivil', type: 'string', mapping: 'estadoCivil'},
			{name: 'dataNascimento', type: 'date', dateFormat:'Y-m-d H:i:s', mapping: 'dataNascimento'},
			{name: 'cpf', type: 'string', mapping: 'cpf'},
			{name: 'rg', type: 'string', mapping: 'rg'},
			{name: 'cnpj', type: 'string', mapping: 'cnpj'},
			{name: 'inscricaoEstadual', type: 'string', mapping: 'ie'},
			{name: 'orgaoExpedidor', type: 'string', mapping: 'orgaoExpedidor'},
			{name: 'renda', type: 'float', mapping: 'renda'},
			{name: 'outroRendimento', type: 'float', mapping: 'outroRendimento'},
			{name: 'empresaTrabalho', type: 'string', mapping: 'empresaTrabalho'},
			{name: 'observacao', type: 'string', mapping: 'observacao'},
			{name: 'status', type: 'boolean', mapping: 'status'}
		])
	}) 
	
	pessoaColuna = new Ext.grid.ColumnModel(
		[{
	        header: 'codPessoa',
	        dataIndex: 'codPessoa', 
	        width: 100,
			readOnly: false,
			hidden: true
	      },{
	        header: '<b>Nome</b>',
	        dataIndex: 'nome', 
	        width: 200,
			readOnly: false
	      },{
	        header: '<b>E-mail</b>',
	        dataIndex: 'email', 
	        width: 150,
			readOnly: false,
			renderer: txtMinusculo
	      },{
	        header: 'Endere�o',
	        dataIndex: 'endereco', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Bairro',
	        dataIndex: 'bairro', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Cidade',
	        dataIndex: 'cidade', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'UF',
	        dataIndex: 'uf', 
	        width: 50,
			readOnly: false,
			hidden: true
	      },{
	        header: 'cep',
	        dataIndex: 'cep', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Empresa',
	        dataIndex: 'empresaTrabalho', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'endereco Trabalho',
	        dataIndex: 'enderecoTrabalho', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Bairro Trabalho',
	        dataIndex: 'bairroTrabalho', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Cidade Trabalho',
	        dataIndex: 'cidadeTrabalho', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'UF Trabalho',
	        dataIndex: 'ufTrabalho', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Tipo Pessoa',
	        dataIndex: 'tipoPessoa', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'codTipoPessoa',
	        dataIndex: 'codTipoPessoa', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'codProfissao',
	        dataIndex: 'codProfissao', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'profissao',
	        dataIndex: 'profissao', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'codEstadoCivil',
	        dataIndex: 'codEstadoCivil', 
	        width: 80,
			hidden: true
	      },{
	        header: 'estadoCivil',
	        dataIndex: 'estadoCivil', 
	        width: 80,
			hidden: true
	      },{	
			header: 'dataNascimento',
			dataIndex: 'dataNascimento', 
			width: 110,
			renderer: formatoData,
			hidden: true
		  },{
	        header: 'Cpf',
	        dataIndex: 'cpf', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Rg',
	        dataIndex: 'rg', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'Cnpj',
	        dataIndex: 'cnpj', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'ie',
	        dataIndex: 'ie', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'orgaoExpedidor',
	        dataIndex: 'orgaoExpedidor', 
	        width: 80,
			readOnly: false,
			hidden: true
	      },{
	        header: 'renda',
	        dataIndex: 'renda', 
	        width: 80,
			renderer: alterarFloat,
			hidden: true
	      },{
	        header: 'outroRendimento',
	        dataIndex: 'outroRendimento', 
	        width: 80,
			renderer: alterarFloat,
			hidden: true
	      },{
	        header: 'Status',
	        dataIndex: 'status', 
	        width: 50,
			hidden: true,
			readOnly: true
	      },{
	        header: '<b>Excluir</b>',
	        dataIndex: 'status', 
	        width: 50,
			align: 'center',
			renderer: usuarioExcluir,
			readOnly: true
	      }
	])	
	pessoaColuna.defaultSortable = true


	cbProprietario = new Ext.form.ComboBox({
		id: 'cbProprietario',
		typeAhead: false,
		fieldLabel: '<b>Propriet�rio</b>',
		value: '',
		mode: 'local',
		editable: false,
		anchor: '98%',
		store: storeProprietario,
		emptyText:"Selecione um propriet�rio.",
		displayField: 'nome',
		valueField: 'codPessoa',
		forceSelection: true,
		triggerAction: 'all'

	})


	cbContratante = new Ext.form.ComboBox({
		id: 'cbContratante',
		typeAhead: false,
		fieldLabel: '<b>Contratante</b>',
		value: '',
		mode: 'local',
		editable: false,
		anchor: '98%',
		store: storeContratante,
		emptyText:"Selecione o contratante",
		displayField: 'nome',
		valueField: 'codPessoa',
		forceSelection: true,
		triggerAction: 'all'

	})

	cbImovel = new Ext.form.ComboBox({
		id: 'cbImovel',
		typeAhead: false,
		fieldLabel: '<b>Im�vel</b>',
		value: '',
		mode: 'local',
		editable: false,
		anchor: '98%',
		store: storeImovel,
		emptyText:"Selecione um im�vel.",
		displayField: 'endereco',
		valueField: 'codImovel',
		forceSelection: true,
		triggerAction: 'all'

	})	


	cbUf = new Ext.form.ComboBox({
		xtype: 'combo',
		id: 'cbUf',
		typeAhead: false,
		//name: 'uf',
		fieldLabel: '<b>UF</b>',
		value: '',
		mode: 'local',
		editable: false,
		store:ufStore,
		disabled: true,
		displayField: 'uf',
		valueField: 'uf',
		forceSelection: true,
		triggerAction: 'all',
		anchor: '95%'
	})

	tfNome = new Ext.form.TextField({
		fieldLabel: '<b>Nome</b>',
		//name: 'nome',
		id: 'tfNome',
		allowBlank:false,
		blankText:"Por favor entre com o endere�o do im�vel.",
		maxLength: 100,
		anchor : '98%'
	})

	tfEndereco = new Ext.form.TextField({
		fieldLabel: '<b>Endere�o</b>',
		//name: 'endereco',
		id: 'tfEndereco',
		allowBlank:false,
		disabled: true,	
		blankText:"Por favor insira o endere�o.",
		maxLength: 100,
		anchor : '98%'
	})
		
	tfBairro = new Ext.form.TextField({
		fieldLabel: '<b>Bairro</b>',
		//name: 'bairro',
		id: 'tfBairro',
		disabled: true,	
		allowBlank:false,
		blankText:"Por favor insira o bairro.",
		maxLength: 100,
		anchor : '98%'
	})
	
	tfCidade = new Ext.form.TextField({
		fieldLabel: '<b>Cidade</b>',
		//name: 'cidade',
		id: 'tfCidade',
		disabled: true,	
		allowBlank:false,
		blankText:"Por favor insira a cidade.",
		maxLength: 100,
		anchor: '95%'
	})

	tfCep = new Ext.form.TextField({
		fieldLabel: '<b>CEP</b>',
		//name: 'cep',
		id: 'tfCep',
		disabled: true,	
		allowBlank:false,
		blankText:"Por favor insira a cidade.",
		maxLength: 100,
		anchor: '95%'
	})

	tfDocumento = new Ext.form.TextField({
		fieldLabel: '<b>Documento</b>',
		id: 'tfDocumento',
		maxLength: 100,
		anchor: '60%',
		disabled: true
	})

	txObservacoes = new Ext.form.TextArea({
		fieldLabel: '<b>Observa��es</b>',
		id: 'txObservacoes',
		allowBlank: true,
		maxLength: 100,
		anchor : '98%',
		height : 56
	})

	dtInicioLocacao = new Ext.form.DateField({
		id: 'dtInicioLocacao',
		name: 'dtInicioLocacao',
		fieldLabel: '<b>In�cio Loca��o</b>',
		blankText:"Por favor insira a data <b>IN�CIO DA ALOCA��O</b>.",
		allowBlank: false,
		format : 'd/m/Y',
		anchor: '98%'
	})

	dtFimLocacao = new Ext.form.DateField({
		id: 'dtFimLocacao',
		name: 'dtFimLocacao',
		fieldLabel: '<b>Fim Loca��o</b>',
		allowBlank: false,
		disabled: true,
		blankText:"Por favor insira a data <b>FIM DA ALOCA��O</b>.",
		format : 'd/m/Y',
		anchor: '98%'
	})

	tfQtdMeses = new Ext.form.NumberField({
		fieldLabel: '<b>Meses</b>',
		name: 'qtdMeses',
		id: 'tfQtdMeses',
		blankText:"Por favor insira a quantidade de <b>MESES</b>.",
		allowBlank: false,
		allowNegative: false,
		anchor : '95%'
	});
        
        tfIntermediacao = new Ext.form.NumberField({
		fieldLabel: '<b>Intermedia��o(%)</b>',
		name: 'intermediacao',
		id: 'tfIntermediacao',
		blankText:"Por favor insira a intermedia��o.",
		allowBlank: false,
		allowNegative: false,
		anchor : '95%'
	});

	tfValor = {
		xtype: 'masktextfield',
		mask: 'R$ #9.999.990,00',
		money: true,
		fieldLabel: '<b>Valor</b>',
		name: 'valorBase',
		id: 'tfValor',
		allowBlank:false,
		blankText:"Por favor insira o <b>VALOR</b>.",
		autoCreate: {tag: 'input', type: 'text', maxlength: '5'}, //seta o tamanho m�ximo q o input vai aceitar
		anchor : '95%'
	}
	
	tfDescPontualidade = {
		xtype: 'masktextfield',
		mask: 'R$ #9.999.990,00',
		money: true,
		fieldLabel: '<b>Desc. Pont</b>',
		name: 'tfDescPontualidade',
		id: 'tfDescPontualidade',
		autoCreate: {tag: 'input', type: 'text', maxlength: '5'}, //seta o tamanho m�ximo q o input vai aceitar
		anchor : '95%'
	}
	
	tfMulta = {
		xtype: 'masktextfield',
		mask: 'R$ #9.999.990,00',
		money: true,
		fieldLabel: '<b>Multa p/ atraso</b>',
		name: 'tfMulta',
		id: 'tfMulta',
		blankText:"Por favor insira o valor da <b>MULTA POR ATRASO</b>.",
		autoCreate: {tag: 'input', type: 'text', maxlength: '5'}, //seta o tamanho m�ximo q o input vai aceitar
		anchor : '95%'
	}

	tfComissao = new Ext.form.NumberField({
		fieldLabel: '<b>Comiss�o %</b>',
		name: 'tfComissao',
		id: 'tfComissao',
		allowBlank:false,
		blankText:"Por favor insira a <b>COMISS�O</b>.",
		anchor : '95%'
	})

	tfTipoPessoa = new Ext.form.TextField({
		fieldLabel: '<b>Tipo de Pessoa</b>',
		name: 'tfTipoPessoa',
		id: 'tfTipoPessoa',
		anchor : '70%',
		disabled: true
	})

		
	
	
	function manterImovel(coluna,statusUsuario,codImovel){
		if(coluna == 13){
			if(statusUsuario == 1){
				if(confirm('Tem certeza que deseja desativar esse im�vel?')){
					Ext.Ajax.request({
						url: 'modulos/imovel/gerenciar_imovel.php',
						params: { 
							acao: 'imovelDesativar',
							codImovel:  codImovel
						},
						callback: function(options, success, response) {
							
							var retorno = Ext.decode(response.responseText);
							
							if(retorno.success == false){
								Ext.MessageBox.alert('ok')
							}else{
								pessoaStore.reload()
								contratoGrid.getForm().reset()
							}
						}
					})
				}
			}else{
				if(confirm('Tem certeza que deseja ativar esse im�vel?')){
					Ext.Ajax.request({
						url: 'modulos/imovel/gerenciar_imovel.php',
						params: { 
							acao: 'imovelAtivar',
							codImovel:  codImovel
						},
						callback: function(options, success, response) {
							
							var retorno = Ext.decode(response.responseText);
							
							if(retorno.success == false){
								msg('Erro', 'Erro ao tentar executar a opera��o!')
							}else{
								pessoaStore.reload()
							}
						}
					})
				}
			}
		}
	
	}



	var gridListaContrato = new Ext.grid.GridPanel({
		id: 'gridListaContrato',
		ds: pessoaStore,
		cm: pessoaColuna,
		title: 'Fiador',
		listeners:{
			cellclick: function(grid,linha,coluna){
				//Verifica se � a coluna de exclus�o
				var dados = grid.store.getAt(linha);
				var codImovel = dados.get('codImovel')
				var statusUsuario = dados.get('status')
				manterImovel(coluna, statusUsuario,codImovel)
				
			},
			rowcontextmenu: function(grid,rowIndex, e){
				e.stopEvent()
				var acao;
				var dados     = grid.store.getAt( rowIndex );
				var codPessoa = dados.get('codPessoa')
				var nome      = dados.get('nome');
				
				if(dados.get('status') == 1){
					acao = 'Desativar';
					status = 'botaoDesativar'; 
				}else{
					acao = 'Ativar';
					status = 'botaoAtivar'; 
				}
				
				var contextMenu = new Ext.menu.Menu();
				contextMenu.add({
					text: acao,
					iconCls: status,
					handler: function (){
						manterPessoa('13', dados.get('status'),codPessoa)
					}
				},{
					text: 'Relacionar Perfis',
					iconCls:'manterUsuario',
					handler: function (){
						perfisRelacionar(codPessoa,nome)
					}
				});
				
				contextMenu.showAt(e.xy);
			}
		},
		viewConfig: {
			forceFit: true,
			getRowClass: function(record, rowIndex, rp, ds){
				if(record.data.status == '0'){
					return 'linhaDesativada'
				}
			}
		}, 
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true,
			listeners: {
				rowselect: function(sm, row, rec) {
					codPessoaSelecionada = rec.data.codPessoa

					if(rec.data.codContrato != 0){
						Ext.getCmp("contratoGrid").getForm().loadRecord(rec)
					}
				}			
			}
		}),
		autoExpandColumn: 'codImovel',
		height: 127,
		border: true,
		bbar: [			
			botaoNovoFiador = new Ext.Button({
				text: 'Novo',
				tooltip: 'Novo',
				handler: novo,   
				iconCls:'botaoNovo'
			}),'-',
			botaoNovoFiador= new Ext.Button({
				text: 'Salvar',
				tooltip: 'Salvar',
				handler: salvar,
				iconCls:'botaoSalvar'
			})
		]
	})

	var contratoGrid = new Ext.FormPanel({
        id: 'contratoGrid',
        frame: true,
		autoHeight: true,
        labelAlign: 'left',
        layout: 'column',	
		items: [{
        	columnWidth: 0.50,
            xtype: 'fieldset',
			style: 'margin: 0px 5px 0px 0px;',
            title:'Dados do Im�veEl', 
			bodyStyle: Ext.isIE ? 'padding:0 0 0px 10px' : 'padding: 10px 10px 5px 10px',
            items:[{
				layout:'column',
				width: '100%',
				border: false,
				items: [{	
					columnWidth: 1,
					labelWidth: 85,
					layout: 'form',
					autoHeight: true,
					border: false,
					items: [cbProprietario]
				},{	
					columnWidth: 1,
					labelWidth: 85,
					layout: 'form',
					autoHeight: true,
					border: false,
					items: [cbImovel]
				},{
					columnWidth: 1,
					labelWidth: 85,
					layout: 'form',
					border: false,
					items: [tfEndereco]
				},{
					columnWidth: 0.7,
					labelWidth: 85,
					layout: 'form',
					items: [tfBairro]
				},{
					columnWidth: 0.3,
					labelWidth: 40,
					layout: 'form',
					items: [tfCep]
				},{
					columnWidth: 0.8,
					labelWidth: 85,
					layout: 'form',
					items: [tfCidade]
				},{
					columnWidth: 0.2,
					labelWidth: 30,
					layout: 'form',
					items: [cbUf]
				},{
					columnWidth: 1,
					labelWidth: 85,
					layout: 'form',
					items: [txObservacoes]
				}]
			}]
				
        },{
            columnWidth: 0.50,
            xtype: 'fieldset',
			style: 'margin: 0px 0px 5px 5px;',
            title:'Dados do Contratante', 
			bodyStyle: Ext.isIE ? 'padding:0 0 5px 10px' : 'padding: 10px 10px 5px 10px',
            items:[{
				layout:'column',
				width: '100%',
				border: false,
				items: [{	
					columnWidth: 1,
					labelWidth: 100,
					layout: 'form',
					autoHeight: true,
					border: false,
					items: [cbContratante]
				},{
					columnWidth: 1,
					labelWidth: 100,
					layout: 'form',
					autoHeight: true,
					border: false,
					items: [tfTipoPessoa]
				},{
					columnWidth: 1,
					labelWidth: 100,
					layout: 'form',
					autoHeight: true,
					border: false,
					items: [tfDocumento]
					
				}]
			}]
				
        },{
            columnWidth: .5,
            xtype: 'fieldset',
			style: 'margin: 0px 0px 0px 5px;',
            title:'Dados do Contrato', 
			bodyStyle: Ext.isIE ? 'padding:0 0 5px 10px' : 'padding: 10px 0px 5px 10px',
            items:[{
				layout:'column',
				width: '100%',
				border: false,
				items: [{	
					columnWidth: .5,
					labelWidth : 95,
					layout     : 'form',
					autoHeight : true,
					border     : false,
					items      : [dtInicioLocacao]
				},{	
					columnWidth: .5,
					labelWidth : 80,
					layout     : 'form',
					autoHeight : true,
					border     : false,
					items      : [dtFimLocacao]
				},{
					columnWidth: .35,
					labelWidth : 80,
					layout     : 'form',
					items: [tfComissao]
				},{
					columnWidth: .25,
					labelWidth : 45,
					layout     : 'form',
					items      : [tfQtdMeses]
				},{
					columnWidth: .40,
					labelWidth : 45,
					layout     : 'form',
					items      : [tfValor]
				},{
					columnWidth: .5,
					labelWidth: 95,
					layout: 'form',
					items: [tfDescPontualidade]
				},{
					columnWidth: .5,
					labelWidth: 110,
					layout: 'form',
					items: [tfMulta]
				}]
			}]
				
        }],	
		bbar: ['->',
			
			botaoNovo = new Ext.Button({
				text: 'Novo',
				tooltip: 'Novo',
				handler: novo,   
				iconCls:'botaoNovo'
			}),'-',

			botaoSalvar= new Ext.Button({
				text: 'Salvar',
				tooltip: 'Salvar',
				handler: salvar,
				iconCls:'botaoSalvar'
			})
		]
    })


cbProprietario.on('select',function(node,checked,e){
	
	document.getElementById('cbImovel').enable = true;
		
	document.getElementById('cbImovel').value = ''
	storeImovel.load({
		params: {
			acao           :'imovelProprietarioListar',
			codProprietario: node.value
		}
	})
})




cbImovel.on('select',function(node,checked,e){
	Ext.Ajax.request({
		url: 'modulos/imovel/gerenciar_imovel.php',
		params: { 
			acao: 'imovelUnicoListar',
			codImovel:  node.value
		},
		callback: function(options, success, response) {
			
			var retorno = Ext.decode(response.responseText);
			
			document.getElementById('tfEndereco').value     = retorno.resultado[0].endereco;
			document.getElementById('tfBairro').value       = retorno.resultado[0].bairro;
			document.getElementById('tfCep').value          = retorno.resultado[0].cep;
			document.getElementById('tfCidade').value       = retorno.resultado[0].cidade;
			document.getElementById('cbUf').value           = retorno.resultado[0].uf;
			document.getElementById('txObservacoes').value  = retorno.resultado[0].observacao;

		}
	})
})

cbContratante.on('select',function(node,checked,e){
	Ext.Ajax.request({
		url: 'modulos/usuario/gerenciar_usuario.php',
		params: { 
			acao: 'pessoaUnicoListar',
			codPessoa:  node.value
		},
		callback: function(options, success, response) {
			
			var retorno = Ext.decode(response.responseText);
			
			document.getElementById('tfTipoPessoa').value = retorno.resultado[0].nomePessoaTipo;
			document.getElementById('tfDocumento').value  = retorno.resultado[0].documento;

		}
	})
})


function novo(){
	contratoGrid.getForm().reset()
	codContratoSelecionado = 0
}	

function salvar (){
		if((cbProprietario.getValue()!= '' &&
			cbImovel.getValue()!= '' &&
			cbContratante.getValue()!= '' &&
			tfComissao.getValue()!= '' &&
			dtInicioLocacao.getValue()!= '' &&
			tfQtdMeses.getValue()!= '' &&
			document.getElementById("tfValor").value != '' &&
			document.getElementById("tfMulta").value != '' &&
			txObservacoes.getValue()!= ''
		)){
			
			
			Ext.Ajax.request({
				url: 'modulos/contrato/gerenciar_contrato.php',
				params: { 
					acao                 : 'contratoCadastrar',
					codContrato          : codContratoSelecionado,
					codProprietario      : cbProprietario.getValue(),
					codImovel            : cbImovel.getValue(),
					codContratante       : cbContratante.getValue(),
					codTipoServico       : 1,
					comissao             : tfComissao.getValue(),
					dataInicio           : formatoDia(dtInicioLocacao.getValue()),
					qtdMeses			 : tfQtdMeses.getValue(),
					descontoPontualidade : document.getElementById("tfDescPontualidade").value,
					valor                : document.getElementById("tfValor").value,
					multaAtraso          : document.getElementById("tfMulta").value,					
					observacoes          : txObservacoes.getValue()
				},
				callback: function(options, success, response) {
					var retorno = Ext.decode(response.responseText);
					
					if(retorno.success == false){
						msg('Informa��o','Problema ao cadastrar o contrato!')
					}else{
						msg('Informa��o','Opera��o executada com sucesso!')
					}
				}
			})

			novo()
		}else{
			contratoGrid.getForm().submit()
			msg('Informa��o','Existem campos obrigat�rios em Branco!')
		}	
		
		
	
}
	pessoaStore.load({params: {start: 0, limit: 15}})


	var janelaGerenciarContrato = new Ext.Window({
		title: 'Gerenciar Contrato',
		id: 'janelaGerenciarContrato',
		border: false,
		draggable: true,
		resizable: false,
		shadow: false,
		autoHeight: true,
		width: 900,
		height: 600,
		closeAction:'close',
		iconCls: 'manterUsuario',
		modal: true,
		items:[contratoGrid]
	})
	janelaGerenciarContrato.show()

	
	
	if(codContratoSelecionado != 0){

		Ext.Ajax.request({
			url: 'modulos/contrato/gerenciar_contrato.php',
			params: { 
				acao: 'contratoUnicoListar',
				codContrato:  codContratoSelecionado
			},
			callback: function(options, success, response) {
				
				var retorno = Ext.decode(response.responseText);
			
				
				Ext.getCmp("cbProprietario").setValue(retorno.resultado[0].codProprietario);
				Ext.getCmp("cbProprietario").setRawValue(retorno.resultado[0].proprietario);

				
				Ext.getCmp("cbContratante").setValue(retorno.resultado[0].codContratante);
				Ext.getCmp("cbContratante").setRawValue(retorno.resultado[0].inquilino);

				
				Ext.getCmp("cbImovel").setValue(retorno.resultado[0].codImovel);
				Ext.getCmp("cbImovel").setRawValue(retorno.resultado[0].endereco);

				Ext.getCmp("dtInicioLocacao").setValue(retorno.resultado[0].dataInicio);
				Ext.getCmp("dtFimLocacao").setValue(retorno.resultado[0].dataFim);
				Ext.getCmp("tfValor").setValue(retorno.resultado[0].valor);
				Ext.getCmp("tfComissao").setValue(retorno.resultado[0].comissao);
				Ext.getCmp("tfMulta").setValue(retorno.resultado[0].multaAtraso);
				Ext.getCmp("tfDescPontualidade").setValue(retorno.resultado[0].descontoPontualidade);
				Ext.getCmp("tfQtdMeses").setValue(retorno.resultado[0].qtdMeses);
				document.getElementById('txObservacoes').value  = retorno.resultado[0].observacao;
				

				storeImovel.load({
					params: {
						acao           :'imovelProprietarioListar',
						codProprietario: retorno.resultado[0].codProprietario
					}
				})
				
				Ext.Ajax.request({
					url: 'modulos/imovel/gerenciar_imovel.php',
					params: { 
						acao: 'imovelUnicoListar',
						codImovel:  retorno.resultado[0].codImovel
					},
					callback: function(options, success, response) {
						
						var retorno = Ext.decode(response.responseText);
						
						document.getElementById('tfEndereco').value     = retorno.resultado[0].endereco;
						document.getElementById('tfBairro').value       = retorno.resultado[0].bairro;
						document.getElementById('tfCep').value          = retorno.resultado[0].cep;
						document.getElementById('tfCidade').value       = retorno.resultado[0].cidade;
						document.getElementById('cbUf').value           = retorno.resultado[0].uf;
						

					}
				})


				Ext.Ajax.request({
					url: 'modulos/usuario/gerenciar_usuario.php',
					params: { 
						acao: 'pessoaUnicoListar',
						codPessoa:  retorno.resultado[0].codContratante
					},
					callback: function(options, success, response) {
						
						var retorno = Ext.decode(response.responseText);
						
						document.getElementById('tfTipoPessoa').value = retorno.resultado[0].nomePessoaTipo;
						document.getElementById('tfDocumento').value  = retorno.resultado[0].documento;

					}
				})

			}
		})
		

		
	}
}