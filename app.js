let selected_area = 0; // 0 = Funcionários, 1 = Projetos, 2 = Departamentos
let loaded_json = "";
let selected = false;

$(window).on("load", function() {
    // Load selected area
    loadArea(selected_area);

    $("button").on("click", function() {
        $(".content").empty();
        $("button").removeClass("selected")
        switch(this.id) {
            case "b_func":
                selected_area = 0;
                $(this).addClass("selected");
            break;
            case "b_proj":
                selected_area = 1;
                $(this).addClass("selected");
            break;
            case "b_dept":
                selected_area = 2;
                $(this).addClass("selected");
            break;
        }
        loadArea(selected_area);
    })
});

function loadArea(id) {
    $.ajax({
        url: "loadMain.php?area=" + id,
        type: "GET",
        success: function(result) {
            console.log(result);
            renderResult(result);
        }
    })
}

function renderResult(data) {
    parsedResult = $.parseJSON(data);
    parsedResult.forEach(function(a) {
        if (selected_area == 0) {
            $(".content").append(
                '<div class="item" id="' + a.id + '">'+
                    '<text>' + a.nome + '</text><br>' +
                    '<text>' + a.proj + '</text>' + 
                '</div>');
        } else {
            $(".content").append(
                '<div class="item" id="' + a.id + '">'+
                    '<text>' + a.nome + '</text>' +
                '</div>');
        }
    });
    $(".item").on("click", function() {
        renderSelectedItem(selected_area, this.id);
    })
}

function deleteEmployee(id) {
    $.ajax({
        url: "manageEmployee.php?type=delete&id=" + id,
        type: "GET"
    });
}

function renderSelectedItem(sel, id, res) {
    let name = "";
    let cpf = "";
    let proj = 0;
    let dept = 0;

    // clear screen
    $(".content").empty();
    console.log(id);

    if (sel == 0) {
        // get user credentials
        $.ajax({
            type: "GET",
            url: "getCredentials.php?id=" + id,
            success: function(result) {
                console.log(result);
                p_json = $.parseJSON(result);
                name = p_json.name;
                cpf = p_json.cpf;
                proj = p_json.id_proj
                dept = p_json.id_dept;
            }
        }).done(function() {
            $(".content").append('<form action="atualizarFuncionario.php">' +
                '<div class="separator">'+
                '<label for="func_id">ID: </label>' +
                '<input type="text" id="func_id" name="func_id" value="' + id + '" readonly="readonly"></input>' +
                '</div>'+

                '<div class="separator">'+
                '<label for="name">Nome: </label>'+
                '<input type="text" id="name" name="name" value="' + name + '">'+
                '</div>'+

                '<div class="separator">'+
                '<label for="cpf">CPF: </label>'+
                '<input type="text" id="cpf" name="cpf" value="' + cpf + '">'+
                '</div>'+

                '<div class="departamento">' +
                    '<div class="separator">'+
                        '<label for="id_proj">Projeto:  </label>'+
                        '<select id="id_proj" name="id_proj" value="' + proj + '">'+
                            '<option value="1">website</option>'+
                        '</select>'+
                    '</div>'+

                    '<div class="separador">'+
                        '<label for="id_dept">Departamento: </label>'+
                        '<select id="id_dept" name="id_dept" value="' + dept + '">'+
                            '<option value="1">Dev Back-End</option>'+
                            '<option value="2">Dev Front-End</option>'+
                        '</select><br><br>'+
                    '</div>'+
                '</div>' +

                '<div class="botoes">'+
                    '<button type="submit" name="action" value="update" class="submitForm">Atualizar</button>'+
                    '<button type="submit" name="action" value="remove" class="submitForm removeButton">Remover</button>'+
                '</div>'+
            '</form>');
        });
    }
}

function addNew(){
    $(".content").empty();
    if (selected_area == 0) {
        $(".content").append('<form action="addFuncionario.php">'+
            '<label for="name">Nome: </label>'+
            '<input type="text" id="name" name="name"><br><br>'+

            '<label for="cpf">CPF: </label>'+
            '<input type="text" id="cpf" name="cpf"><br><br>'+

            '<label for="id_proj">Projeto: </label>'+
            '<select id="id_proj" name="id_proj">'+
                '<option value="1">website</option>'+
            '</select>'+

            '<label for="id_dept">Departamento: </label>'+
            '<select id="id_dept" name="id_dept">'+
                '<option value="1">Dev Back-End</option>'+
                '<option value="2">Dev Front-End</option>'+
            '</select>'+

            '<input type="submit" value="Submit">'+
        '</form>');
    }
}