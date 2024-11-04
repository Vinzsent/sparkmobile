min_num : {
    validators : {
        integer : { 
            message : 'Please enter the valid number ',
            min : 1,
            max : 'max_num'
        },
        notEmpty : {
            message : 'Please enter the number'
        }
    }
},
max_num : {
    validators : {
        integer : {
            message : 'Please enter the valid number ',
            min : 'min_num',
            max : 10000
        },
        notEmpty : {
            message : 'Please enter the number'
        }
    }
}