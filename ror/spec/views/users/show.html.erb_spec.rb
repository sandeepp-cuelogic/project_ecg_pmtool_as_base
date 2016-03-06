require 'rails_helper'

RSpec.describe "users/show", type: :view do
  before(:each) do
    @user = assign(:user, User.create!(
      :name => "Name",
      :address => "Address",
      :mobilenumber => "Mobilenumber",
      :email => "Email",
      :password => "Password"
    ))
  end

  it "renders attributes in <p>" do
    render
    expect(rendered).to match(/Name/)
    expect(rendered).to match(/Address/)
    expect(rendered).to match(/Mobilenumber/)
    expect(rendered).to match(/Email/)
    expect(rendered).to match(/Password/)
  end
end
