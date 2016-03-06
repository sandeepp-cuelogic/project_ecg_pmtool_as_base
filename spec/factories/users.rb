FactoryGirl.define do
  factory :user do
    name "Prashant"
    address "MyString"
    mobilenumber "MyString"
    email "MyString"
    password "MyString"

    factory :invalid_user do
      name nil
      email nil
    end  
  end

end
