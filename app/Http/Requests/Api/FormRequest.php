<?php

    namespace App\Http\Requests\Api;

    use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
    use \Illuminate\Contracts\Validation\Validator;
    use Waavi\Sanitizer\Laravel\SanitizesInput;
    use Illuminate\Validation\ValidationException;


    abstract class FormRequest extends LaravelFormRequest
    {
        use SanitizesInput;

        /**
         * For more sanitizer rule check https://github.com/Waavi/Sanitizer
         */
        public function validateResolved()
        {
            {
                $this->sanitize();
                parent::validateResolved();
            }
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        abstract public function rules();

        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        abstract public function authorize();

        /**
         * Handle a failed validation attempt.
         *
         * @param  Validator  $validator
         * @return mixed
         */
        protected function failedValidation(Validator $validator)
        {
					$message = '';
					foreach ($validator->errors()->messages() as $key => $errorArray) {
						foreach ($errorArray as $error) {
							$message .= $error . ' ';
						}	
					}
						http_response_code(403);
            exit(json_encode([
                'status' => false,
								'errors' => $validator->errors()->messages(),
								'message' => $message,
            ]));
        }
    }
