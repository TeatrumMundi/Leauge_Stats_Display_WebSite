document.getElementById('region-select').addEventListener('change', function ()
        {
            this.classList.add('selected-option');
        }
    );

    document.getElementById('tag-input').addEventListener('input', function ()
        {
            let textbox = document.getElementById('tag-input');
            if(!textbox.value.startsWith('#'))
            {
                textbox.value = '#' + textbox.value;
            }
        }
    );