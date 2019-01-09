<?php

return [
    'ERR_INVALID_USER_PASS'                 => 'Invalid username or password entered!',
    'ERR_SAVE_MEM_ERROR_MESSAGE'            => 'Failed to save member, Something went wrong.',
    'ERR_EXAM_BOOK_MESSAGE'                 => 'Exam slot booked successfully',
    'ERR_SAVE_EXM_ERROR_MESSAGE'            => 'Failed to save exam slot, Something went wrong.',
    'ERR_SAVE_EXM_FAIL_ERROR_MESSAGE'       => 'Server failure, Please try again later.',
    'ERR_RESET_PASSWORD_MESSAGE'            => 'Password reset link has sent to your mail address.',
    'ERR_STR_ERR_FROM_EMAIL_MESSAGE'        => 'Please enter a email',
    'ERR_STR_LOGIN_SUCCESSFULLY_MESSAGE'    => 'Login successfully.',
    'ERR_STR_EMAIL_ERROR_MESSAGE'           => 'Invalid Email Id or Password',
    'ERR_STR_PASSWORD_ERROR_MESSAGE'        => 'Incorrect password is entered !',
    'ERR_STR_WRN_EMAIL_ERROR_MESSAGE'       => 'Invalid Email Id is entered !',
    'ERR_STR_INACTIVE_ERROR_MESSAGE'        => 'Sorry!! You are account is not actived.',
    'ERR_STR_EMPTY_FIELD_ERROR_MESSAGE'     => 'Please enter a data',
    'ERR_STR_TOKEN_ERROR_MESSAGE'           => 'Token is invalid',
    'ERR_STR_PASSWORD_SUCCESS_MESSAGE'      => 'Password has been updated successfully.',
    'ERR_STR_EMAILID_ERROR_MESSAGE'         => 'Please enter valid Email Id',
    'ERR_STR_CREDENTIALS_ERROR_MESSAGE'     => 'Entered credentials is incorrect',
    'ERR_STR_EMPTY_VOUCHER_ERR_MSG'         => 'Please Enter a voucher code',
    'ERR_STR_INVALID_VOUCHER_ERR_MSG'       => 'Invalid voucher code',
    'ERR_STR_EXP_VOUCHER_ERR_MSG'           => 'This voucher code is expired',
    'ERR_EXPIRED_EXAM'                      => 'This exam has been expired.',
    'ERR_STR_VOUCHER_SUCC_MSG'              => 'Your Voucher added successfully',
    'ERR_STR_USE_VOUCHER_ERR_MSG'           => 'This voucher has expired',
    'ERR_STR_DB_VOUCHER_ERRO_MSG'           => 'somthing is worng',
    'ERR_EMPTY_COURSE_ERRO_MSG'             => 'No course found',
    'ERR_USER_VERIFICATION_ERRO_MSG'        => 'User verification failed',

    //Internal Server error  // __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
    'ERR_INTERNAL_SERVER_ERRO_MSG'  => 'Failed to process request due to internal server error, Please try again later.',
    
    //Comman messages
    'ERR_STATUS_ERROR_MSG'              => 'Status changed successfully.',
    'ERR_NOT_FOUND_ERROR_MSG'           => 'Not Found',
    'ERR_MAIL_SUCCESS_MSG'              => 'Mail has been sent successfully',

    //Concil member
    'ERR_CONCIL_MEM_SUCCESS_MSG'            => 'Concil member saved successfully.',
    'ERR_CONCIL_MEM__UPDATE_SUCCESS_MSG'    => 'Concil member details updated successfully.',
    'ERR_CONCIL_MEM__DELETE_SUCCESS_MSG'    => 'Council member deleted successfully.',

    //Course 
    'ERR_COURSE_SUCCESS_MSG'           => 'Course saved successfully.',
    'ERR_COURSE_UPDATE_SUCCESS_MSG'    => 'Course details updated successfully.',
    'ERR_COURSE_DELETE_SUCCESS_MSG'    => 'Course deleted successfully.',
    'ERR_COURSE_STS_DEP_ERROR_MSG'     => 'Can\'t change status, This course has been purchased.',
    'ERR_COURSE_DEL_DEP_ERROR_MSG'     => 'Can\'t delete, This course has been purchased.',

    //Exam
    'ERR_EXAM_SUCCESS_MSG'           => 'Exam saved successfully.',
    'ERR_EXAM_UPDATE_SUCCESS_MSG'    => 'Exam details updated successfully.',
    'ERR_EXAM_DELETE_SUCCESS_MSG'    => 'Exam deleted successfully.',
    'ERR_EXAM_STS_DEP_ERROR_MSG'     => 'Can\'t change status, This course has been purchased.',
    'ERR_EXAM_DEL_DEP_ERROR_MSG'     => 'Can\'t delete, This Exam has been purchased.',
    'ERR_EXAM_QUE_ERROR_MSG'         => 'Exam question must be greater than or equal to total number of questions',
    'ERR_EXAM_TIME_ERROR_MSG'        => 'Exam start times must not be same for respective day.',
    'ERR_EXAM_DAY_ERROR_MSG'         => 'Exam days must not be same.',
    
    //Prerequisite 
    'ERR_PRERE_SUCCESS_MSG'           => 'Prerequisite saved successfully.',
    'ERR_PRERE_EMPTY_ERR_MSG'         => 'Please select atleast one file or url',
    'ERR_PRERE_UPDATE_SUCCESS_MSG'    => 'Prerequisite details updated successfully.',
    'ERR_PRERE_DELETE_SUCCESS_MSG'    => 'Prerequisite deleted successfully.',
    'ERR_PRERE_STS_DEP_ERROR_MSG'     => 'Can\'t change status, This Prerequisite has been used in Course.',
    'ERR_PRERE_DEL_DEP_ERROR_MSG'     => 'Can\'t delete, This Prerequisite has been used in Course.',

    //Question Category
    'ERR_QESTION_CAT_SUCCESS_MSG'           => 'Question Category saved successfully.',
    'ERR_QESTION_CAT_UPDATE_SUCCESS_MSG'    => 'Question Category details updated successfully.',
    'ERR_QESTION_CAT_DELETE_SUCCESS_MSG'    => 'Question Category deleted successfully.',
    'ERR_QESTION_CAT_STS_DEP_ERROR_MSG'     => 'Can\'t change status, This Question category has been used in questions.',
    'ERR_QESTION_CAT_DEL_DEP_ERROR_MSG'     => 'Can\'t delete, This Question category has been used in questions.',


    //Question
    'ERR_QESTION_SUCCESS_MSG'               => 'Question saved successfully.',
    'ERR_QESTION_UPDATE_SUCCESS_MSG'        => 'Question details updated successfully.',
    'ERR_QESTION_DELETE_SUCCESS_MSG'        => 'Question deleted successfully.',
    'ERR_QESTION_STS_DEP_ERROR_MSG'         => 'Can\'t change status, This Question has been used in questions.',
    'ERR_QESTION_DEL_DEP_ERROR_MSG'         => 'Can\'t delete, This Question has been used in Exam.',
    'ERR_QESTION_INDEX_ERROR_MSG'           => 'Given index was not found.',
    'ERR_QESTION_INP_EMPTY_ERROR_MSG'       => 'Right answer input filed should not be empty.',
    'ERR_QESTION_PRE_EMPTY_ERROR_MSG'       => 'Right answer previous input fileds should not be empty.',
    
    //Question type
    'ERR_QESTION_TYP_SUCCESS_MSG'           => 'Question type saved successfully.',
    'ERR_QESTION_TYP_UPDATE_SUCCESS_MSG'    => 'Question type details updated successfully.',
    'ERR_QESTION_TYP_DELETE_SUCCESS_MSG'    => 'Question type deleted successfully.',
    'ERR_QESTION_TYP_STS_DEP_ERROR_MSG'     => 'Can\'t change status, This Question type has been used in questions.',
    'ERR_QESTION_TYP_DEL_DEP_ERROR_MSG'     => 'Can\'t delete, This Question type has been used in questions.',

    //Site setting
    'ERR_SITE_SETTING_SUCCESS_MSG'          => 'Site setting saved successfully.',
    'ERR_SITE_SETTING_UPDATE_SUCCESS_MSG'    => 'Site setting details updated successfully.',

    //Voucher
    'ERR_VOUCHER_SUCCESS_MSG'          => 'Voucher saved successfully.',
    'ERR_VOUCHER_UPDATE_SUCCESS_MSG'   => 'Voucher updated successfully.',
    'ERR_VOUCHER_DELETE_SUCCESS_MSG'   => 'Voucher deleted successfully.',
    
];
